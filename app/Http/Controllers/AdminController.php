<?php

namespace App\Http\Controllers;

use App\Models\FormUser;
use App\Exports\AnswersExport;
use Maatwebsite\Excel\Facades\Excel;

class AdminController extends Controller
{
    public function index()
    {
        $date = request('date');
        $serviceType = request('service_type');

        $query = FormUser::with(['personalData', 'questionnaireAnswers.question', 'questionnaireAnswers.selectedOption']);

        // Filter by date if provided
        if ($date) {
            $query->whereDate('created_at', $date);
        }

        // Filter by service type if provided
        if ($serviceType) {
            $query->whereHas('personalData', function ($q) use ($serviceType) {
                $q->where('service_type', $serviceType);
            });
        }

        $users = $query->orderBy('created_at', 'asc')->paginate(10);
        $questions = \App\Models\Question::with('options')->orderBy('id')->get();

        return view('admin.users', [
            'users' => $users,
            'date' => $date,
            'serviceType' => $serviceType,
            'questions' => $questions
        ]);
    }

    public function answers()
    {
        $startDate = request('start_date');
        $endDate = request('end_date');
        $export = request('export') === 'excel';

        $query = FormUser::with(['questionnaireAnswers.question', 'questionnaireAnswers.selectedOption']);

        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        $answerValues = [
            'Tidak Pernah' => 4,
            'Kadang-kadang' => 3,
            'Sering' => 2,
            'Selalu' => 1
        ];

        $questions = \App\Models\Question::orderBy('id')->get();

        if ($export) {
            $users = $query->orderBy('created_at', 'asc')->get();
            return Excel::download(new AnswersExport($users, $questions, $answerValues), 'data-jawaban-kuisioner-' . now()->format('Y-m-d') . '.xlsx');
        }

        $users = $query->orderBy('created_at', 'asc')->paginate(10);
        return view('admin.answers', compact('users', 'startDate', 'endDate', 'answerValues', 'questions'));
    }

    public function destroy($id)
    {
        try {
            $user = FormUser::findOrFail($id);


            $user->personalData()->delete();
            $user->questionnaireAnswers()->delete();


            $user->delete();

            return redirect()->route('admin.users')
                ->with('success', 'Data pengguna berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('admin.users')
                ->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }
}
