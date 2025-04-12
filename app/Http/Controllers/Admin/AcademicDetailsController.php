<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicSession;
use App\Models\Department;
use App\Models\Semester;
use Illuminate\Http\Request;

class AcademicDetailsController extends Controller
{
    // Sessions Methods
    public function sessions()
    {
        $sessions = AcademicSession::all();
        return view('admin.session', compact('sessions'));
    }

    public function addSession()
    {
        return view('admin.add-session');
    }

    public function storeSession(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:academic_sessions'
        ]);

        AcademicSession::create($request->all());

        return redirect()->route('admin.sessions')->with('success', 'Session added successfully');
    }

    public function updateSession(Request $request, $academicSession)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:academic_sessions,name,' . $request->academicSession
        ]);

        $session = AcademicSession::findOrFail($request->academicSession);
        
        $session->update([
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $request->has('is_active') ? 1 : 0
        ]);

        return redirect()->route('admin.sessions')->with('success', 'Session updated successfully');
    }

    public function destroySession($academicSession)
    {
        $session = AcademicSession::findOrFail($academicSession);
        
        // Check if session has departments
        if ($session->departments()->count() > 0) {
            return redirect()->back()->with('error', 'Cannot delete this session as it has departments associated with it');
        }
        
        $session->delete();

        return redirect()->route('admin.sessions')->with('success', 'Session deleted successfully');
    }

    // Departments Methods
    public function departments()
    {
        $departments = Department::with('academicSession')->get();
        return view('admin.department', compact('departments'));
    }

    public function addDepartment()
    {
        $sessions = AcademicSession::all();
        return view('admin.add-department', compact('sessions'));
    }

    public function storeDepartment(Request $request)
    {
        $request->validate([
            'academic_session_id' => 'required|exists:academic_sessions,id',
            'name' => 'required|string|max:255'
        ]);

        Department::create([
            'academic_session_id' => $request->academic_session_id, 
            'name' => $request->name
        ]);

        return redirect()->route('admin.departments')->with('success', 'Department added successfully');
    }

    public function updateDepartment(Request $request, $department)
    {
        $request->validate([
            'academic_session_id' => 'required|exists:academic_sessions,id',
            'name' => 'required|string|max:255'
        ]);

        $dept = Department::findOrFail($request->department);
        $dept->update([
            'academic_session_id' => $request->academic_session_id,
            'name' => $request->name
        ]);

        return redirect()->route('admin.departments')->with('success', 'Department updated successfully');
    }

    public function destroyDepartment(Department $department)
    {
        // Check if department has semesters
        if ($department->semesters()->count() > 0) {
            return redirect()->back()->with('error', 'Cannot delete this department as it has semesters associated with it');
        }
        
        $department->delete();

        return redirect()->route('admin.departments')->with('success', 'Department deleted successfully');
    }

    public function getDepartmentsBySession($sessionId)
    {
        $departments = Department::where('academic_session_id', $sessionId)->get();
        return response()->json($departments);
    }

    // Semesters Methods
    public function semesters()
    {
        $semesters = Semester::with('department.academicSession')->get();
        return view('admin.semester', compact('semesters'));
    }

    public function addSemester()
    {
        $sessions = AcademicSession::all();
        $departments = Department::all();
        return view('admin.add-semester', compact('sessions', 'departments'));
    }

    public function storeSemester(Request $request)
    {
        $request->validate([
            'department_id' => 'required|exists:departments,id',
            'type' => 'required|in:odd,even',
            'months' => 'required|array|min:1'
        ]);

        // Create the semester with the validated data
        Semester::create([
            'department_id' => $request->department_id,
            'type' => $request->type,
            'months' => $request->months,
            'is_active' => true
        ]);

        return redirect()->route('admin.semesters')->with('success', 'Semester added successfully');
    }

    public function updateSemester(Request $request, Semester $semester)
    {
        $request->validate([
            'department_id' => 'required|exists:departments,id',
            'type' => 'required|in:odd,even',
            'months' => 'required|array|min:1'
        ]);

        // Update the semester with the validated data
        $semester->update([
            'department_id' => $request->department_id,
            'type' => $request->type,
            'months' => $request->months,
            'is_active' => true
        ]);

        return redirect()->route('admin.semesters')->with('success', 'Semester updated successfully');
    }

    public function destroySemester(Semester $semester)
    {
        $semester->delete();

        return redirect()->route('admin.semesters')->with('success', 'Semester deleted successfully');
    }
} 