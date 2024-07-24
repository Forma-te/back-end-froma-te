<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct(
        protected UserService $userService
    ) {
    }

    public function index()
    {
        return view('admin.pages.home.dashboard');
    }

    public function getAllProducers(Request $request)
    {
        $producers = $this->userService->getAllProducers(
            page: $request->get('page', 1),
            totalPerPage: $request->get('totalPerPage', 10),
            filter: $request->get('filter')
        );

        return view('admin.pages.producer.producers', compact('producers'));
    }

}
