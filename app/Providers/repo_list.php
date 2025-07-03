<?php

declare(strict_types=1);

namespace App\Providers\Repositories;

return [
    [
        'interface' => \App\Repositories\Interfaces\ActionBtnSettingRepositoryInterface::class,
        'class' => \App\Repositories\ActionBtnSettingRepository::class,
    ],[
        'interface' => \App\Repositories\Interfaces\AppLogRepositoryInterface::class,
        'class' => \App\Repositories\AppLogRepository::class,
    ], [
        'interface' => \App\Repositories\Interfaces\BinderRepositoryInterface::class,
        'class' => \App\Repositories\BinderRepository::class,
    ], [
        'interface' => \App\Repositories\Interfaces\BinderBuildingCategoryRepositoryInterface::class,
        'class' => \App\Repositories\BinderBuildingCategoryRepository::class,
    ], [
        'interface' => \App\Repositories\Interfaces\BuildingRepositoryInterface::class,
        'class' => \App\Repositories\BuildingRepository::class,
    ], [
        'interface' => \App\Repositories\Interfaces\BuildingStatusRepositoryInterface::class,
        'class' => \App\Repositories\BuildingStatusRepository::class,
    ], [
        'interface' => \App\Repositories\Interfaces\BuildingInvitationRepositoryInterface::class,
        'class' => \App\Repositories\BuildingInvitationRepository::class,
    ], [
        'interface' => \App\Repositories\Interfaces\CustomerRepositoryInterface::class,
        'class' => \App\Repositories\CustomerRepository::class,
    ], [
        'interface' => \App\Repositories\Interfaces\CustomerPinRepositoryInterface::class,
        'class' => \App\Repositories\CustomerPinRepository::class,
    ], [
        'interface' => \App\Repositories\Interfaces\DashboardSelectBuildingRepositoryInterface::class,
        'class' => \App\Repositories\DashboardSelectBuildingRepository::class,
    ], [
        'interface' => \App\Repositories\Interfaces\DisplayCustomerListColumnRepositoryInterface::class,
        'class' => \App\Repositories\DisplayCustomerListColumnRepository::class,
    ], [
        'interface' => \App\Repositories\Interfaces\FloorTypeRepositoryInterface::class,
        'class' => \App\Repositories\FloorTypeRepository::class,
    ], [
        'interface' => \App\Repositories\Interfaces\ImageGalleryRepositoryInterface::class,
        'class' => \App\Repositories\ImageGalleryRepository::class,
    ], [
        'interface' => \App\Repositories\Interfaces\LimitedContentRepositoryInterface::class,
        'class' => \App\Repositories\LimitedContentRepository::class,
    ], [
        'interface' => \App\Repositories\Interfaces\ManagerRepositoryInterface::class,
        'class' => \App\Repositories\ManagerRepository::class,
    ], [
        'interface' => \App\Repositories\Interfaces\MasterDataRepositoryInterface::class,
        'class' => \App\Repositories\MasterDataRepository::class,
    ], [
        'interface' => \App\Repositories\Interfaces\MovieCategoryRepositoryInterface::class,
        'class' => \App\Repositories\MovieCategoryRepository::class,
    ], [
        'interface' => \App\Repositories\Interfaces\MovieRepositoryInterface::class,
        'class' => \App\Repositories\MovieRepository::class,
    ], [
        'interface' => \App\Repositories\Interfaces\SalesScheduleRepositoryInterface::class,
        'class' => \App\Repositories\SalesScheduleRepository::class,
    ], [
        'interface' => \App\Repositories\Interfaces\ShareContentStatusRepositoryInterface::class,
        'class' => \App\Repositories\ShareContentStatusRepository::class,
    ], [
        'interface' => \App\Repositories\Interfaces\ShareItemStatusRepositoryInterface::class,
        'class' => \App\Repositories\ShareItemStatusRepository::class,
    ],
];
