<?php

namespace App\Services\User;

use App\Mail\IssueSolve;
use App\Models\Company;
use App\Models\User;
use App\Models\Issue;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;

class IssueService
{

    protected $issue;

    public function __construct()
    {
        $this->issue = new Issue; // Use $this->issue to assign the instance to the class property.
    }

    public function index($request)
    {
        $hrId = $request->company;
        $user = User::where('company_id', $hrId)->get();
        return response()->json(['hrs' => $user]);
    }

    public function store($request)
    {
        $slug = Str::slug($request->title, '-', Str::random(5));
        $company = Company::where('uuid', $request->issueUuid)->first();
        $this->issue->fill($request->all());
        $this->issue->slug = $slug;
        $this->issue->company_id = $company->id;
        $this->issue->save();
        return response()->json(['success' => __('entity.entityCreated', ['entity' => 'Issue'])]);
    }

    public function show($id)
    {
        return Issue::with('user')->findOrFail($id);
    }

    public function edit($issue)
    {
        $hrId = auth()->user()->id;
        // dd($user);
        if ($hrId == $issue->hr_id) {
            $manager = User::where('parent_id', $hrId)->get();
            return view('hr.issue.create', ['issue' => $issue, 'managers' => $manager]);
        } else {
            return abort(404);
        }
    }

    public function update($id, $request){
        if ($request->status == 'COMPLETED') {
            $issue = Issue::find($id);
            $email = $issue->email;
            Mail::to($email)->send(new IssueSolve($issue));
        }

        Issue::find($id)->fill($request->all())->save();
        if (auth()->user()->hasRole('hr')) {
            $route = route('hr.issue.index');
        } else {
            $route = route('manager.issue.index');
        }
        return  response()->json([
            'success' => __('entity.entityUpdated', ['entity' => 'Issue']),
            'route' => $route
        ]);
    }


    public function destroy($request)
    {
        Issue::find($request->id)->delete();
        return  response()->json([
            'success' => __('entity.entityDeleted', ['entity' => 'Company']),
        ]);
    }

    public function collection($request)
    {
        if ($request->table == config('site.table.hr')) {
            return $this->hrIssue($request);
        } else if ($request->table == config('site.table.manager')) {
            return $this->managerIssue($request);
        }
    }

    public function hrIssue($request){

        $id = auth()->user()->id;
        $query = Issue::with('user')->where('hr_id', $id);

        if ($request->listing == 'pending') {
            $query = Issue::with('user')->whereNull(['due_date', 'manager_id'])->where('hr_id', $id);
        }

        if ($request->filter) {
            $query->where('priority', $request->filter);
        }
        if ($request->duedate) {
            $query->where('due_date', $request->duedate);
        }

        return DataTables::of($query)
            ->orderColumn('title', function ($query, $order) {
                $query->orderBy('id', $order);
            })
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $editRoute = route('hr.issue.edit', ['issue' => $row->id]);
                $actionBtn = '<a href=' . $editRoute . ' data-issueId="' . $row->id . '" class="view btn btn-primary btn-sm">View</a>';
                return $actionBtn;
            })
            
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function managerIssue($request)
    {
        $companyId = auth()->user()->id;
        // dd($companyId);
        $query = Issue::where('manager_id', $companyId)->select('id', 'title', 'manager_id', 'priority', 'due_date', 'status');
        if ($request->filter) {
            $query->where('priority', $request->filter);
        }
        if ($request->duedate) {
            $query->where('due_date', $request->duedate);
        }
        return DataTables::of($query)
            ->orderColumn('title', function ($query, $order) {
                $query->orderBy('id', $order);
            })
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $editRoute = route('manager.issue.edit', ['issue' => $row->id]);
                $actionBtn = '<a href=' . $editRoute . ' data-issueId="' . $row->id . '" class="view btn btn-primary btn-sm">View</a>';
                return $actionBtn;
            })

            ->rawColumns(['status', 'action'])
            ->make(true);
    }
}
