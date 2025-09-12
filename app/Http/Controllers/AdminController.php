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

        // Get total users who have filled out personal data
        $totalRespondents = FormUser::has('personalData')->count();

        $query = FormUser::with(['personalData', 'questionnaireAnswers.question', 'questionnaireAnswers.selectedOption']);

        // For dashboard view
        if (request()->routeIs('admin.dashboard')) {
            $totalQuestionnaires = FormUser::has('questionnaireAnswers')->count();

            // Get average score using the same method as landing page
            $scoreData = $this->getAverageScore();

            return view('admin.dashboard', [
                'totalRespondents' => $totalRespondents,
                'totalQuestionnaires' => $totalQuestionnaires,
                'averageScore' => $scoreData['average']
            ]);
        }

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

        $users = $query->orderBy('created_at', 'desc')->paginate(10);
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

        // Clone the query for pagination
        $paginatedQuery = (clone $query)->orderBy('created_at', 'desc');

        // Get all users for score calculation
        $allUsers = $query->get();

        // Get paginated users for display
        $users = $paginatedQuery->paginate(10);

        return view('admin.answers', compact('users', 'allUsers', 'startDate', 'endDate', 'answerValues', 'questions'));
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

    /**
     * Calculate average score for all answers
     */
    public function getAverageScore()
    {
        $answerValues = [
            'Tidak Pernah' => 4,
            'Kadang-kadang' => 3,
            'Sering' => 2,
            'Selalu' => 1
        ];

        $totalScore = 0;
        $totalResponses = 0;

        // Get all answers
        $answers = \App\Models\QuestionnaireAnswer::with('selectedOption')->get();


        foreach ($answers as $answer) {
            if (isset($answerValues[$answer->selectedOption->option_text])) {
                $totalScore += $answerValues[$answer->selectedOption->option_text];
                $totalResponses++;
            }
        }

        // Calculate average score (raw average, not percentage)
        $average = $totalResponses > 0
            ? $totalScore / $totalResponses
            : 0;

        // Round to 2 decimal places
        $average = round($average, 2);

        // Determine category based on the 1-4 scale
        $category = $this->getScoreCategory($average);

        return [
            'average' => $average,
            'category' => $category
        ];
    }


    protected function getScoreCategory($score)
    {
        if ($score >= 4.51) {
            return [
                'name' => 'Sangat Baik',
                'description' => 'Kualitas pelayanan sangat memuaskan dan melebihi harapan.'
            ];
        } elseif ($score >= 3.51) {
            return [
                'name' => 'Baik',
                'description' => 'Kualitas pelayanan baik dan memenuhi harapan.'
            ];
        } elseif ($score >= 2.51) {
            return [
                'name' => 'Cukup',
                'description' => 'Kualitas pelayanan cukup, namun perlu peningkatan.'
            ];
        } else {
            return [
                'name' => 'Kurang',
                'description' => 'Kualitas pelayanan perlu ditingkatkan.'
            ];
        }
    }
}
