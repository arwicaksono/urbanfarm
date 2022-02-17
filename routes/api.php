<?php

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:sanctum']], function () {
    // Permissions
    Route::apiResource('permissions', 'PermissionsApiController');

    // Roles
    Route::apiResource('roles', 'RolesApiController');

    // Users
    Route::post('users/media', 'UsersApiController@storeMedia')->name('users.storeMedia');
    Route::apiResource('users', 'UsersApiController');

    // User Alerts
    Route::apiResource('user-alerts', 'UserAlertsApiController');

    // Site Setting
    Route::apiResource('site-settings', 'SiteSettingApiController');

    // Unit Area
    Route::apiResource('unit-areas', 'UnitAreaApiController');

    // Att Tag
    Route::apiResource('att-tags', 'AttTagApiController');

    // Site
    Route::post('sites/media', 'SiteApiController@storeMedia')->name('sites.storeMedia');
    Route::apiResource('sites', 'SiteApiController');

    // Employee
    Route::post('employees/media', 'EmployeeApiController@storeMedia')->name('employees.storeMedia');
    Route::apiResource('employees', 'EmployeeApiController');

    // Employee Position
    Route::apiResource('employee-positions', 'EmployeePositionApiController');

    // Module System
    Route::apiResource('module-systems', 'ModuleSystemApiController');

    // Module Activity
    Route::apiResource('module-activities', 'ModuleActivityApiController');

    // Unit Capacity
    Route::apiResource('unit-capacities', 'UnitCapacityApiController');

    // Module
    Route::post('modules/media', 'ModuleApiController@storeMedia')->name('modules.storeMedia');
    Route::apiResource('modules', 'ModuleApiController');

    // Att Category
    Route::apiResource('att-categories', 'AttCategoryApiController');

    // Unit Quantity
    Route::apiResource('unit-quantities', 'UnitQuantityApiController');

    // Product Grade
    Route::apiResource('product-grades', 'ProductGradeApiController');

    // Att Status
    Route::apiResource('att-statuses', 'AttStatusApiController');

    // Harvest
    Route::post('harvests/media', 'HarvestApiController@storeMedia')->name('harvests.storeMedia');
    Route::apiResource('harvests', 'HarvestApiController');

    // Unit Weight
    Route::apiResource('unit-weights', 'UnitWeightApiController');

    // Packing
    Route::post('packings/media', 'PackingApiController@storeMedia')->name('packings.storeMedia');
    Route::apiResource('packings', 'PackingApiController');

    // Employee Status
    Route::apiResource('employee-statuses', 'EmployeeStatusApiController');

    // Att Priority
    Route::apiResource('att-priorities', 'AttPriorityApiController');

    // Nutrient Control
    Route::post('nutrient-controls/media', 'NutrientControlApiController@storeMedia')->name('nutrient-controls.storeMedia');
    Route::apiResource('nutrient-controls', 'NutrientControlApiController');

    // Distribution
    Route::post('distributions/media', 'DistributionApiController@storeMedia')->name('distributions.storeMedia');
    Route::apiResource('distributions', 'DistributionApiController');

    // Unit Temperature
    Route::apiResource('unit-temperatures', 'UnitTemperatureApiController');

    // Att Type
    Route::apiResource('att-types', 'AttTypeApiController');

    // Business Setting
    Route::post('business-settings/media', 'BusinessSettingApiController@storeMedia')->name('business-settings.storeMedia');
    Route::apiResource('business-settings', 'BusinessSettingApiController');

    // Site Inspection
    Route::post('site-inspections/media', 'SiteInspectionApiController@storeMedia')->name('site-inspections.storeMedia');
    Route::apiResource('site-inspections', 'SiteInspectionApiController');

    // Plant Assessment
    Route::post('plant-assessments/media', 'PlantAssessmentApiController@storeMedia')->name('plant-assessments.storeMedia');
    Route::apiResource('plant-assessments', 'PlantAssessmentApiController');

    // Module Observation
    Route::post('module-observations/media', 'ModuleObservationApiController@storeMedia')->name('module-observations.storeMedia');
    Route::apiResource('module-observations', 'ModuleObservationApiController');

    // Module Component
    Route::post('module-components/media', 'ModuleComponentApiController@storeMedia')->name('module-components.storeMedia');
    Route::apiResource('module-components', 'ModuleComponentApiController');

    // Att Category Comp
    Route::apiResource('att-category-comps', 'AttCategoryCompApiController');

    // Unit Age
    Route::apiResource('unit-ages', 'UnitAgeApiController');

    // Att Efficacy
    Route::apiResource('att-efficacies', 'AttEfficacyApiController');

    // Sales Channel
    Route::apiResource('sales-channels', 'SalesChannelApiController');

    // Sales Market
    Route::post('sales-markets/media', 'SalesMarketApiController@storeMedia')->name('sales-markets.storeMedia');
    Route::apiResource('sales-markets', 'SalesMarketApiController');

    // Sales Label
    Route::apiResource('sales-labels', 'SalesLabelApiController');

    // Sales Delivery
    Route::apiResource('sales-deliveries', 'SalesDeliveryApiController');

    // Sales Customer
    Route::post('sales-customers/media', 'SalesCustomerApiController@storeMedia')->name('sales-customers.storeMedia');
    Route::apiResource('sales-customers', 'SalesCustomerApiController');

    // Purchase Brand
    Route::post('purchase-brands/media', 'PurchaseBrandApiController@storeMedia')->name('purchase-brands.storeMedia');
    Route::apiResource('purchase-brands', 'PurchaseBrandApiController');

    // Purchase Company
    Route::post('purchase-companies/media', 'PurchaseCompanyApiController@storeMedia')->name('purchase-companies.storeMedia');
    Route::apiResource('purchase-companies', 'PurchaseCompanyApiController');

    // Purchase Contact
    Route::post('purchase-contacts/media', 'PurchaseContactApiController@storeMedia')->name('purchase-contacts.storeMedia');
    Route::apiResource('purchase-contacts', 'PurchaseContactApiController');

    // Purchase Equipment
    Route::post('purchase-equipments/media', 'PurchaseEquipmentApiController@storeMedia')->name('purchase-equipments.storeMedia');
    Route::apiResource('purchase-equipments', 'PurchaseEquipmentApiController');

    // Purchase Substance
    Route::post('purchase-substances/media', 'PurchaseSubstanceApiController@storeMedia')->name('purchase-substances.storeMedia');
    Route::apiResource('purchase-substances', 'PurchaseSubstanceApiController');

    // Care Pre Order
    Route::post('care-pre-orders/media', 'CarePreOrderApiController@storeMedia')->name('care-pre-orders.storeMedia');
    Route::apiResource('care-pre-orders', 'CarePreOrderApiController');

    // Site Water Source
    Route::apiResource('site-water-sources', 'SiteWaterSourceApiController');

    // Site Weather
    Route::apiResource('site-weathers', 'SiteWeatherApiController');

    // Cashflow Expense Categories
    Route::apiResource('cashflow-expense-categories', 'CashflowExpenseCategoriesApiController');

    // Cashflow Income
    Route::post('cashflow-incomes/media', 'CashflowIncomeApiController@storeMedia')->name('cashflow-incomes.storeMedia');
    Route::apiResource('cashflow-incomes', 'CashflowIncomeApiController');

    // Cashflow Expense
    Route::post('cashflow-expenses/media', 'CashflowExpenseApiController@storeMedia')->name('cashflow-expenses.storeMedia');
    Route::apiResource('cashflow-expenses', 'CashflowExpenseApiController');

    // Cashflow Income Category
    Route::apiResource('cashflow-income-categories', 'CashflowIncomeCategoryApiController');

    // Employee Job Desc
    Route::post('employee-job-descs/media', 'EmployeeJobDescApiController@storeMedia')->name('employee-job-descs.storeMedia');
    Route::apiResource('employee-job-descs', 'EmployeeJobDescApiController');

    // Admin Plan
    Route::post('admin-plans/media', 'AdminPlanApiController@storeMedia')->name('admin-plans.storeMedia');
    Route::apiResource('admin-plans', 'AdminPlanApiController');

    // Admin Setting
    Route::post('admin-settings/media', 'AdminSettingApiController@storeMedia')->name('admin-settings.storeMedia');
    Route::apiResource('admin-settings', 'AdminSettingApiController');

    // Admin Info
    Route::post('admin-infos/media', 'AdminInfoApiController@storeMedia')->name('admin-infos.storeMedia');
    Route::apiResource('admin-infos', 'AdminInfoApiController');

    // Admin Database
    Route::post('admin-databases/media', 'AdminDatabaseApiController@storeMedia')->name('admin-databases.storeMedia');
    Route::apiResource('admin-databases', 'AdminDatabaseApiController');

    // Admin Category
    Route::post('admin-categories/media', 'AdminCategoryApiController@storeMedia')->name('admin-categories.storeMedia');
    Route::apiResource('admin-categories', 'AdminCategoryApiController');

    // Admin Tag
    Route::apiResource('admin-tags', 'AdminTagApiController');

    // Admin Expert
    Route::post('admin-experts/media', 'AdminExpertApiController@storeMedia')->name('admin-experts.storeMedia');
    Route::apiResource('admin-experts', 'AdminExpertApiController');

    // Team
    Route::apiResource('teams', 'TeamApiController');

    // Cashflow Sales
    Route::post('cashflow-sales/media', 'CashflowSalesApiController@storeMedia')->name('cashflow-sales.storeMedia');
    Route::apiResource('cashflow-sales', 'CashflowSalesApiController');

    // Cashflow Purchase
    Route::post('cashflow-purchases/media', 'CashflowPurchaseApiController@storeMedia')->name('cashflow-purchases.storeMedia');
    Route::apiResource('cashflow-purchases', 'CashflowPurchaseApiController');

    // Plot
    Route::post('plots/media', 'PlotApiController@storeMedia')->name('plots.storeMedia');
    Route::apiResource('plots', 'PlotApiController');

    // Plot Plant
    Route::apiResource('plot-plants', 'PlotPlantApiController');

    // Plot Stage
    Route::apiResource('plot-stages', 'PlotStageApiController');

    // Plot Variety
    Route::apiResource('plot-varieties', 'PlotVarietyApiController');

    // Plot Codes
    Route::apiResource('plot-codes', 'PlotCodesApiController');

    // Care Harvest
    Route::post('care-harvests/media', 'CareHarvestApiController@storeMedia')->name('care-harvests.storeMedia');
    Route::apiResource('care-harvests', 'CareHarvestApiController');

    // Care Packing
    Route::post('care-packings/media', 'CarePackingApiController@storeMedia')->name('care-packings.storeMedia');
    Route::apiResource('care-packings', 'CarePackingApiController');

    // Care Distribution
    Route::post('care-distributions/media', 'CareDistributionApiController@storeMedia')->name('care-distributions.storeMedia');
    Route::apiResource('care-distributions', 'CareDistributionApiController');

    // Care Module
    Route::post('care-modules/media', 'CareModuleApiController@storeMedia')->name('care-modules.storeMedia');
    Route::apiResource('care-modules', 'CareModuleApiController');

    // Care Site
    Route::post('care-sites/media', 'CareSiteApiController@storeMedia')->name('care-sites.storeMedia');
    Route::apiResource('care-sites', 'CareSiteApiController');

    // Care Plant Assessment
    Route::post('care-plant-assessments/media', 'CarePlantAssessmentApiController@storeMedia')->name('care-plant-assessments.storeMedia');
    Route::apiResource('care-plant-assessments', 'CarePlantAssessmentApiController');

    // Care Nutrient Control
    Route::post('care-nutrient-controls/media', 'CareNutrientControlApiController@storeMedia')->name('care-nutrient-controls.storeMedia');
    Route::apiResource('care-nutrient-controls', 'CareNutrientControlApiController');

    // Care Sale
    Route::post('care-sales/media', 'CareSaleApiController@storeMedia')->name('care-sales.storeMedia');
    Route::apiResource('care-sales', 'CareSaleApiController');

    // Care Purchase
    Route::post('care-purchases/media', 'CarePurchaseApiController@storeMedia')->name('care-purchases.storeMedia');
    Route::apiResource('care-purchases', 'CarePurchaseApiController');

    // Employee Attendance
    Route::post('employee-attendances/media', 'EmployeeAttendanceApiController@storeMedia')->name('employee-attendances.storeMedia');
    Route::apiResource('employee-attendances', 'EmployeeAttendanceApiController');

    // Employee Leave
    Route::apiResource('employee-leaves', 'EmployeeLeaveApiController');

    // Emp Leave Type
    Route::apiResource('emp-leave-types', 'EmpLeaveTypeApiController');

    // Task
    Route::post('tasks/media', 'TaskApiController@storeMedia')->name('tasks.storeMedia');
    Route::apiResource('tasks', 'TaskApiController');

    // Sales Payment
    Route::apiResource('sales-payments', 'SalesPaymentApiController');
});
