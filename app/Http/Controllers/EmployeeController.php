<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\CSVFileService;
use App\Services\EmployeeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Foundation\Application;


class EmployeeController extends Controller
{
    /**
     * @var CSVFileService $csvFileService
     */
    private CSVFileService $csvFileService;

    /**
     * @var EmployeeService $employeeService
     */
    private EmployeeService $employeeService;

    /**
     * EmployeeController constructor.
     * @param CSVFileService $csvFileService
     * @param EmployeeService $employeeService
     */
    public function __construct(CSVFileService $csvFileService, EmployeeService $employeeService)
    {
        $this->csvFileService = $csvFileService;
        $this->employeeService = $employeeService;
    }

    /**
     * @return Application|Factory|View
     */
    public function index(): view
    {
        return view('home');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function uploadCSV(Request $request): JsonResponse
    {
        $file = $request->file('file');
        $employees = $this->csvFileService->getArray($file);

        $avg = $this->employeeService->avgMatch($employees);
        $avg['status'] = 'success';

        return response()->json($avg);
    }
}

