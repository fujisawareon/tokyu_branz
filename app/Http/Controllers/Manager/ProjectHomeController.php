<?php

declare(strict_types=1);

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Building;
use App\Services\ManagerService;
use App\Traits\FormTrait;
use Illuminate\View\View;

class ProjectHomeController extends Controller
{
    use FormTrait;

    /** @var ManagerService */
    private ManagerService $manager_service;

    /**
     * コンストラクタ
     */
    public function __construct ()
    {
        $this->manager_service = app(ManagerService::class);
    }

    public function __invoke(Building $building): View
    {
        return view('manager.project.home', [
            'building' => $building,
            'person_charge' => $building->personCharge,
        ]);
    }

}
