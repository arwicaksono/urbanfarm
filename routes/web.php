<?php

Route::redirect('/', '/login');
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Route::get('userVerification/{token}', 'UserVerificationController@approve')->name('userVerification');
Auth::routes();

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth', '2fa']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::post('permissions/parse-csv-import', 'PermissionsController@parseCsvImport')->name('permissions.parseCsvImport');
    Route::post('permissions/process-csv-import', 'PermissionsController@processCsvImport')->name('permissions.processCsvImport');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::post('roles/parse-csv-import', 'RolesController@parseCsvImport')->name('roles.parseCsvImport');
    Route::post('roles/process-csv-import', 'RolesController@processCsvImport')->name('roles.processCsvImport');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::post('users/media', 'UsersController@storeMedia')->name('users.storeMedia');
    Route::post('users/ckmedia', 'UsersController@storeCKEditorImages')->name('users.storeCKEditorImages');
    Route::post('users/parse-csv-import', 'UsersController@parseCsvImport')->name('users.parseCsvImport');
    Route::post('users/process-csv-import', 'UsersController@processCsvImport')->name('users.processCsvImport');
    Route::resource('users', 'UsersController');

    // User Alerts
    Route::delete('user-alerts/destroy', 'UserAlertsController@massDestroy')->name('user-alerts.massDestroy');
    Route::get('user-alerts/read', 'UserAlertsController@read');
    Route::resource('user-alerts', 'UserAlertsController');

    // Site Setting
    Route::delete('site-settings/destroy', 'SiteSettingController@massDestroy')->name('site-settings.massDestroy');
    Route::post('site-settings/parse-csv-import', 'SiteSettingController@parseCsvImport')->name('site-settings.parseCsvImport');
    Route::post('site-settings/process-csv-import', 'SiteSettingController@processCsvImport')->name('site-settings.processCsvImport');
    Route::resource('site-settings', 'SiteSettingController');

    // Unit Area
    Route::delete('unit-areas/destroy', 'UnitAreaController@massDestroy')->name('unit-areas.massDestroy');
    Route::post('unit-areas/parse-csv-import', 'UnitAreaController@parseCsvImport')->name('unit-areas.parseCsvImport');
    Route::post('unit-areas/process-csv-import', 'UnitAreaController@processCsvImport')->name('unit-areas.processCsvImport');
    Route::resource('unit-areas', 'UnitAreaController');

    // Att Tag
    Route::delete('att-tags/destroy', 'AttTagController@massDestroy')->name('att-tags.massDestroy');
    Route::post('att-tags/parse-csv-import', 'AttTagController@parseCsvImport')->name('att-tags.parseCsvImport');
    Route::post('att-tags/process-csv-import', 'AttTagController@processCsvImport')->name('att-tags.processCsvImport');
    Route::resource('att-tags', 'AttTagController');

    // Site
    Route::delete('sites/destroy', 'SiteController@massDestroy')->name('sites.massDestroy');
    Route::post('sites/media', 'SiteController@storeMedia')->name('sites.storeMedia');
    Route::post('sites/ckmedia', 'SiteController@storeCKEditorImages')->name('sites.storeCKEditorImages');
    Route::post('sites/parse-csv-import', 'SiteController@parseCsvImport')->name('sites.parseCsvImport');
    Route::post('sites/process-csv-import', 'SiteController@processCsvImport')->name('sites.processCsvImport');
    Route::resource('sites', 'SiteController');

    // Employee
    Route::delete('employees/destroy', 'EmployeeController@massDestroy')->name('employees.massDestroy');
    Route::post('employees/media', 'EmployeeController@storeMedia')->name('employees.storeMedia');
    Route::post('employees/ckmedia', 'EmployeeController@storeCKEditorImages')->name('employees.storeCKEditorImages');
    Route::post('employees/parse-csv-import', 'EmployeeController@parseCsvImport')->name('employees.parseCsvImport');
    Route::post('employees/process-csv-import', 'EmployeeController@processCsvImport')->name('employees.processCsvImport');
    Route::resource('employees', 'EmployeeController');

    // Employee Position
    Route::delete('employee-positions/destroy', 'EmployeePositionController@massDestroy')->name('employee-positions.massDestroy');
    Route::post('employee-positions/parse-csv-import', 'EmployeePositionController@parseCsvImport')->name('employee-positions.parseCsvImport');
    Route::post('employee-positions/process-csv-import', 'EmployeePositionController@processCsvImport')->name('employee-positions.processCsvImport');
    Route::resource('employee-positions', 'EmployeePositionController');

    // Module System
    Route::delete('module-systems/destroy', 'ModuleSystemController@massDestroy')->name('module-systems.massDestroy');
    Route::post('module-systems/parse-csv-import', 'ModuleSystemController@parseCsvImport')->name('module-systems.parseCsvImport');
    Route::post('module-systems/process-csv-import', 'ModuleSystemController@processCsvImport')->name('module-systems.processCsvImport');
    Route::resource('module-systems', 'ModuleSystemController');

    // Module Activity
    Route::delete('module-activities/destroy', 'ModuleActivityController@massDestroy')->name('module-activities.massDestroy');
    Route::post('module-activities/parse-csv-import', 'ModuleActivityController@parseCsvImport')->name('module-activities.parseCsvImport');
    Route::post('module-activities/process-csv-import', 'ModuleActivityController@processCsvImport')->name('module-activities.processCsvImport');
    Route::resource('module-activities', 'ModuleActivityController');

    // Unit Capacity
    Route::delete('unit-capacities/destroy', 'UnitCapacityController@massDestroy')->name('unit-capacities.massDestroy');
    Route::post('unit-capacities/parse-csv-import', 'UnitCapacityController@parseCsvImport')->name('unit-capacities.parseCsvImport');
    Route::post('unit-capacities/process-csv-import', 'UnitCapacityController@processCsvImport')->name('unit-capacities.processCsvImport');
    Route::resource('unit-capacities', 'UnitCapacityController');

    // Module
    Route::delete('modules/destroy', 'ModuleController@massDestroy')->name('modules.massDestroy');
    Route::post('modules/media', 'ModuleController@storeMedia')->name('modules.storeMedia');
    Route::post('modules/ckmedia', 'ModuleController@storeCKEditorImages')->name('modules.storeCKEditorImages');
    Route::post('modules/parse-csv-import', 'ModuleController@parseCsvImport')->name('modules.parseCsvImport');
    Route::post('modules/process-csv-import', 'ModuleController@processCsvImport')->name('modules.processCsvImport');
    Route::resource('modules', 'ModuleController');

    // Att Category
    Route::delete('att-categories/destroy', 'AttCategoryController@massDestroy')->name('att-categories.massDestroy');
    Route::post('att-categories/parse-csv-import', 'AttCategoryController@parseCsvImport')->name('att-categories.parseCsvImport');
    Route::post('att-categories/process-csv-import', 'AttCategoryController@processCsvImport')->name('att-categories.processCsvImport');
    Route::resource('att-categories', 'AttCategoryController');

    // Unit Quantity
    Route::delete('unit-quantities/destroy', 'UnitQuantityController@massDestroy')->name('unit-quantities.massDestroy');
    Route::post('unit-quantities/parse-csv-import', 'UnitQuantityController@parseCsvImport')->name('unit-quantities.parseCsvImport');
    Route::post('unit-quantities/process-csv-import', 'UnitQuantityController@processCsvImport')->name('unit-quantities.processCsvImport');
    Route::resource('unit-quantities', 'UnitQuantityController');

    // Product Grade
    Route::delete('product-grades/destroy', 'ProductGradeController@massDestroy')->name('product-grades.massDestroy');
    Route::post('product-grades/parse-csv-import', 'ProductGradeController@parseCsvImport')->name('product-grades.parseCsvImport');
    Route::post('product-grades/process-csv-import', 'ProductGradeController@processCsvImport')->name('product-grades.processCsvImport');
    Route::resource('product-grades', 'ProductGradeController');

    // Att Status
    Route::delete('att-statuses/destroy', 'AttStatusController@massDestroy')->name('att-statuses.massDestroy');
    Route::post('att-statuses/parse-csv-import', 'AttStatusController@parseCsvImport')->name('att-statuses.parseCsvImport');
    Route::post('att-statuses/process-csv-import', 'AttStatusController@processCsvImport')->name('att-statuses.processCsvImport');
    Route::resource('att-statuses', 'AttStatusController');

    // Harvest
    Route::delete('harvests/destroy', 'HarvestController@massDestroy')->name('harvests.massDestroy');
    Route::post('harvests/media', 'HarvestController@storeMedia')->name('harvests.storeMedia');
    Route::post('harvests/ckmedia', 'HarvestController@storeCKEditorImages')->name('harvests.storeCKEditorImages');
    Route::post('harvests/parse-csv-import', 'HarvestController@parseCsvImport')->name('harvests.parseCsvImport');
    Route::post('harvests/process-csv-import', 'HarvestController@processCsvImport')->name('harvests.processCsvImport');
    Route::resource('harvests', 'HarvestController');

    // Unit Weight
    Route::delete('unit-weights/destroy', 'UnitWeightController@massDestroy')->name('unit-weights.massDestroy');
    Route::post('unit-weights/parse-csv-import', 'UnitWeightController@parseCsvImport')->name('unit-weights.parseCsvImport');
    Route::post('unit-weights/process-csv-import', 'UnitWeightController@processCsvImport')->name('unit-weights.processCsvImport');
    Route::resource('unit-weights', 'UnitWeightController');

    // Packing
    Route::delete('packings/destroy', 'PackingController@massDestroy')->name('packings.massDestroy');
    Route::post('packings/media', 'PackingController@storeMedia')->name('packings.storeMedia');
    Route::post('packings/ckmedia', 'PackingController@storeCKEditorImages')->name('packings.storeCKEditorImages');
    Route::post('packings/parse-csv-import', 'PackingController@parseCsvImport')->name('packings.parseCsvImport');
    Route::post('packings/process-csv-import', 'PackingController@processCsvImport')->name('packings.processCsvImport');
    Route::resource('packings', 'PackingController');

    // Employee Status
    Route::delete('employee-statuses/destroy', 'EmployeeStatusController@massDestroy')->name('employee-statuses.massDestroy');
    Route::post('employee-statuses/parse-csv-import', 'EmployeeStatusController@parseCsvImport')->name('employee-statuses.parseCsvImport');
    Route::post('employee-statuses/process-csv-import', 'EmployeeStatusController@processCsvImport')->name('employee-statuses.processCsvImport');
    Route::resource('employee-statuses', 'EmployeeStatusController');

    // Att Priority
    Route::delete('att-priorities/destroy', 'AttPriorityController@massDestroy')->name('att-priorities.massDestroy');
    Route::post('att-priorities/parse-csv-import', 'AttPriorityController@parseCsvImport')->name('att-priorities.parseCsvImport');
    Route::post('att-priorities/process-csv-import', 'AttPriorityController@processCsvImport')->name('att-priorities.processCsvImport');
    Route::resource('att-priorities', 'AttPriorityController');

    // Nutrient Control
    Route::delete('nutrient-controls/destroy', 'NutrientControlController@massDestroy')->name('nutrient-controls.massDestroy');
    Route::post('nutrient-controls/media', 'NutrientControlController@storeMedia')->name('nutrient-controls.storeMedia');
    Route::post('nutrient-controls/ckmedia', 'NutrientControlController@storeCKEditorImages')->name('nutrient-controls.storeCKEditorImages');
    Route::post('nutrient-controls/parse-csv-import', 'NutrientControlController@parseCsvImport')->name('nutrient-controls.parseCsvImport');
    Route::post('nutrient-controls/process-csv-import', 'NutrientControlController@processCsvImport')->name('nutrient-controls.processCsvImport');
    Route::resource('nutrient-controls', 'NutrientControlController');

    // Distribution
    Route::delete('distributions/destroy', 'DistributionController@massDestroy')->name('distributions.massDestroy');
    Route::post('distributions/media', 'DistributionController@storeMedia')->name('distributions.storeMedia');
    Route::post('distributions/ckmedia', 'DistributionController@storeCKEditorImages')->name('distributions.storeCKEditorImages');
    Route::post('distributions/parse-csv-import', 'DistributionController@parseCsvImport')->name('distributions.parseCsvImport');
    Route::post('distributions/process-csv-import', 'DistributionController@processCsvImport')->name('distributions.processCsvImport');
    Route::resource('distributions', 'DistributionController');

    // Unit Temperature
    Route::delete('unit-temperatures/destroy', 'UnitTemperatureController@massDestroy')->name('unit-temperatures.massDestroy');
    Route::post('unit-temperatures/parse-csv-import', 'UnitTemperatureController@parseCsvImport')->name('unit-temperatures.parseCsvImport');
    Route::post('unit-temperatures/process-csv-import', 'UnitTemperatureController@processCsvImport')->name('unit-temperatures.processCsvImport');
    Route::resource('unit-temperatures', 'UnitTemperatureController');

    // Att Type
    Route::delete('att-types/destroy', 'AttTypeController@massDestroy')->name('att-types.massDestroy');
    Route::post('att-types/parse-csv-import', 'AttTypeController@parseCsvImport')->name('att-types.parseCsvImport');
    Route::post('att-types/process-csv-import', 'AttTypeController@processCsvImport')->name('att-types.processCsvImport');
    Route::resource('att-types', 'AttTypeController');

    // Business Setting
    Route::delete('business-settings/destroy', 'BusinessSettingController@massDestroy')->name('business-settings.massDestroy');
    Route::post('business-settings/media', 'BusinessSettingController@storeMedia')->name('business-settings.storeMedia');
    Route::post('business-settings/ckmedia', 'BusinessSettingController@storeCKEditorImages')->name('business-settings.storeCKEditorImages');
    Route::post('business-settings/parse-csv-import', 'BusinessSettingController@parseCsvImport')->name('business-settings.parseCsvImport');
    Route::post('business-settings/process-csv-import', 'BusinessSettingController@processCsvImport')->name('business-settings.processCsvImport');
    Route::resource('business-settings', 'BusinessSettingController');

    // Site Inspection
    Route::delete('site-inspections/destroy', 'SiteInspectionController@massDestroy')->name('site-inspections.massDestroy');
    Route::post('site-inspections/media', 'SiteInspectionController@storeMedia')->name('site-inspections.storeMedia');
    Route::post('site-inspections/ckmedia', 'SiteInspectionController@storeCKEditorImages')->name('site-inspections.storeCKEditorImages');
    Route::post('site-inspections/parse-csv-import', 'SiteInspectionController@parseCsvImport')->name('site-inspections.parseCsvImport');
    Route::post('site-inspections/process-csv-import', 'SiteInspectionController@processCsvImport')->name('site-inspections.processCsvImport');
    Route::resource('site-inspections', 'SiteInspectionController');

    // Plant Assessment
    Route::delete('plant-assessments/destroy', 'PlantAssessmentController@massDestroy')->name('plant-assessments.massDestroy');
    Route::post('plant-assessments/media', 'PlantAssessmentController@storeMedia')->name('plant-assessments.storeMedia');
    Route::post('plant-assessments/ckmedia', 'PlantAssessmentController@storeCKEditorImages')->name('plant-assessments.storeCKEditorImages');
    Route::post('plant-assessments/parse-csv-import', 'PlantAssessmentController@parseCsvImport')->name('plant-assessments.parseCsvImport');
    Route::post('plant-assessments/process-csv-import', 'PlantAssessmentController@processCsvImport')->name('plant-assessments.processCsvImport');
    Route::resource('plant-assessments', 'PlantAssessmentController');

    // Module Observation
    Route::delete('module-observations/destroy', 'ModuleObservationController@massDestroy')->name('module-observations.massDestroy');
    Route::post('module-observations/media', 'ModuleObservationController@storeMedia')->name('module-observations.storeMedia');
    Route::post('module-observations/ckmedia', 'ModuleObservationController@storeCKEditorImages')->name('module-observations.storeCKEditorImages');
    Route::post('module-observations/parse-csv-import', 'ModuleObservationController@parseCsvImport')->name('module-observations.parseCsvImport');
    Route::post('module-observations/process-csv-import', 'ModuleObservationController@processCsvImport')->name('module-observations.processCsvImport');
    Route::resource('module-observations', 'ModuleObservationController');

    // Module Component
    Route::delete('module-components/destroy', 'ModuleComponentController@massDestroy')->name('module-components.massDestroy');
    Route::post('module-components/media', 'ModuleComponentController@storeMedia')->name('module-components.storeMedia');
    Route::post('module-components/ckmedia', 'ModuleComponentController@storeCKEditorImages')->name('module-components.storeCKEditorImages');
    Route::post('module-components/parse-csv-import', 'ModuleComponentController@parseCsvImport')->name('module-components.parseCsvImport');
    Route::post('module-components/process-csv-import', 'ModuleComponentController@processCsvImport')->name('module-components.processCsvImport');
    Route::resource('module-components', 'ModuleComponentController');

    // Att Category Comp
    Route::delete('att-category-comps/destroy', 'AttCategoryCompController@massDestroy')->name('att-category-comps.massDestroy');
    Route::post('att-category-comps/parse-csv-import', 'AttCategoryCompController@parseCsvImport')->name('att-category-comps.parseCsvImport');
    Route::post('att-category-comps/process-csv-import', 'AttCategoryCompController@processCsvImport')->name('att-category-comps.processCsvImport');
    Route::resource('att-category-comps', 'AttCategoryCompController');

    // Unit Age
    Route::delete('unit-ages/destroy', 'UnitAgeController@massDestroy')->name('unit-ages.massDestroy');
    Route::post('unit-ages/parse-csv-import', 'UnitAgeController@parseCsvImport')->name('unit-ages.parseCsvImport');
    Route::post('unit-ages/process-csv-import', 'UnitAgeController@processCsvImport')->name('unit-ages.processCsvImport');
    Route::resource('unit-ages', 'UnitAgeController');

    // Att Efficacy
    Route::delete('att-efficacies/destroy', 'AttEfficacyController@massDestroy')->name('att-efficacies.massDestroy');
    Route::post('att-efficacies/parse-csv-import', 'AttEfficacyController@parseCsvImport')->name('att-efficacies.parseCsvImport');
    Route::post('att-efficacies/process-csv-import', 'AttEfficacyController@processCsvImport')->name('att-efficacies.processCsvImport');
    Route::resource('att-efficacies', 'AttEfficacyController');

    // Sales Channel
    Route::delete('sales-channels/destroy', 'SalesChannelController@massDestroy')->name('sales-channels.massDestroy');
    Route::post('sales-channels/parse-csv-import', 'SalesChannelController@parseCsvImport')->name('sales-channels.parseCsvImport');
    Route::post('sales-channels/process-csv-import', 'SalesChannelController@processCsvImport')->name('sales-channels.processCsvImport');
    Route::resource('sales-channels', 'SalesChannelController');

    // Sales Market
    Route::delete('sales-markets/destroy', 'SalesMarketController@massDestroy')->name('sales-markets.massDestroy');
    Route::post('sales-markets/media', 'SalesMarketController@storeMedia')->name('sales-markets.storeMedia');
    Route::post('sales-markets/ckmedia', 'SalesMarketController@storeCKEditorImages')->name('sales-markets.storeCKEditorImages');
    Route::post('sales-markets/parse-csv-import', 'SalesMarketController@parseCsvImport')->name('sales-markets.parseCsvImport');
    Route::post('sales-markets/process-csv-import', 'SalesMarketController@processCsvImport')->name('sales-markets.processCsvImport');
    Route::resource('sales-markets', 'SalesMarketController');

    // Sales Label
    Route::delete('sales-labels/destroy', 'SalesLabelController@massDestroy')->name('sales-labels.massDestroy');
    Route::post('sales-labels/parse-csv-import', 'SalesLabelController@parseCsvImport')->name('sales-labels.parseCsvImport');
    Route::post('sales-labels/process-csv-import', 'SalesLabelController@processCsvImport')->name('sales-labels.processCsvImport');
    Route::resource('sales-labels', 'SalesLabelController');

    // Sales Delivery
    Route::delete('sales-deliveries/destroy', 'SalesDeliveryController@massDestroy')->name('sales-deliveries.massDestroy');
    Route::post('sales-deliveries/parse-csv-import', 'SalesDeliveryController@parseCsvImport')->name('sales-deliveries.parseCsvImport');
    Route::post('sales-deliveries/process-csv-import', 'SalesDeliveryController@processCsvImport')->name('sales-deliveries.processCsvImport');
    Route::resource('sales-deliveries', 'SalesDeliveryController');

    // Sales Customer
    Route::delete('sales-customers/destroy', 'SalesCustomerController@massDestroy')->name('sales-customers.massDestroy');
    Route::post('sales-customers/media', 'SalesCustomerController@storeMedia')->name('sales-customers.storeMedia');
    Route::post('sales-customers/ckmedia', 'SalesCustomerController@storeCKEditorImages')->name('sales-customers.storeCKEditorImages');
    Route::post('sales-customers/parse-csv-import', 'SalesCustomerController@parseCsvImport')->name('sales-customers.parseCsvImport');
    Route::post('sales-customers/process-csv-import', 'SalesCustomerController@processCsvImport')->name('sales-customers.processCsvImport');
    Route::resource('sales-customers', 'SalesCustomerController');

    // Purchase Brand
    Route::delete('purchase-brands/destroy', 'PurchaseBrandController@massDestroy')->name('purchase-brands.massDestroy');
    Route::post('purchase-brands/media', 'PurchaseBrandController@storeMedia')->name('purchase-brands.storeMedia');
    Route::post('purchase-brands/ckmedia', 'PurchaseBrandController@storeCKEditorImages')->name('purchase-brands.storeCKEditorImages');
    Route::post('purchase-brands/parse-csv-import', 'PurchaseBrandController@parseCsvImport')->name('purchase-brands.parseCsvImport');
    Route::post('purchase-brands/process-csv-import', 'PurchaseBrandController@processCsvImport')->name('purchase-brands.processCsvImport');
    Route::resource('purchase-brands', 'PurchaseBrandController');

    // Purchase Company
    Route::delete('purchase-companies/destroy', 'PurchaseCompanyController@massDestroy')->name('purchase-companies.massDestroy');
    Route::post('purchase-companies/media', 'PurchaseCompanyController@storeMedia')->name('purchase-companies.storeMedia');
    Route::post('purchase-companies/ckmedia', 'PurchaseCompanyController@storeCKEditorImages')->name('purchase-companies.storeCKEditorImages');
    Route::post('purchase-companies/parse-csv-import', 'PurchaseCompanyController@parseCsvImport')->name('purchase-companies.parseCsvImport');
    Route::post('purchase-companies/process-csv-import', 'PurchaseCompanyController@processCsvImport')->name('purchase-companies.processCsvImport');
    Route::resource('purchase-companies', 'PurchaseCompanyController');

    // Purchase Contact
    Route::delete('purchase-contacts/destroy', 'PurchaseContactController@massDestroy')->name('purchase-contacts.massDestroy');
    Route::post('purchase-contacts/media', 'PurchaseContactController@storeMedia')->name('purchase-contacts.storeMedia');
    Route::post('purchase-contacts/ckmedia', 'PurchaseContactController@storeCKEditorImages')->name('purchase-contacts.storeCKEditorImages');
    Route::post('purchase-contacts/parse-csv-import', 'PurchaseContactController@parseCsvImport')->name('purchase-contacts.parseCsvImport');
    Route::post('purchase-contacts/process-csv-import', 'PurchaseContactController@processCsvImport')->name('purchase-contacts.processCsvImport');
    Route::resource('purchase-contacts', 'PurchaseContactController');

    // Purchase Equipment
    Route::delete('purchase-equipments/destroy', 'PurchaseEquipmentController@massDestroy')->name('purchase-equipments.massDestroy');
    Route::post('purchase-equipments/media', 'PurchaseEquipmentController@storeMedia')->name('purchase-equipments.storeMedia');
    Route::post('purchase-equipments/ckmedia', 'PurchaseEquipmentController@storeCKEditorImages')->name('purchase-equipments.storeCKEditorImages');
    Route::post('purchase-equipments/parse-csv-import', 'PurchaseEquipmentController@parseCsvImport')->name('purchase-equipments.parseCsvImport');
    Route::post('purchase-equipments/process-csv-import', 'PurchaseEquipmentController@processCsvImport')->name('purchase-equipments.processCsvImport');
    Route::resource('purchase-equipments', 'PurchaseEquipmentController');

    // Purchase Substance
    Route::delete('purchase-substances/destroy', 'PurchaseSubstanceController@massDestroy')->name('purchase-substances.massDestroy');
    Route::post('purchase-substances/media', 'PurchaseSubstanceController@storeMedia')->name('purchase-substances.storeMedia');
    Route::post('purchase-substances/ckmedia', 'PurchaseSubstanceController@storeCKEditorImages')->name('purchase-substances.storeCKEditorImages');
    Route::post('purchase-substances/parse-csv-import', 'PurchaseSubstanceController@parseCsvImport')->name('purchase-substances.parseCsvImport');
    Route::post('purchase-substances/process-csv-import', 'PurchaseSubstanceController@processCsvImport')->name('purchase-substances.processCsvImport');
    Route::resource('purchase-substances', 'PurchaseSubstanceController');

    // Care Pre Order
    Route::delete('care-pre-orders/destroy', 'CarePreOrderController@massDestroy')->name('care-pre-orders.massDestroy');
    Route::post('care-pre-orders/media', 'CarePreOrderController@storeMedia')->name('care-pre-orders.storeMedia');
    Route::post('care-pre-orders/ckmedia', 'CarePreOrderController@storeCKEditorImages')->name('care-pre-orders.storeCKEditorImages');
    Route::post('care-pre-orders/parse-csv-import', 'CarePreOrderController@parseCsvImport')->name('care-pre-orders.parseCsvImport');
    Route::post('care-pre-orders/process-csv-import', 'CarePreOrderController@processCsvImport')->name('care-pre-orders.processCsvImport');
    Route::resource('care-pre-orders', 'CarePreOrderController');

    // Site Water Source
    Route::delete('site-water-sources/destroy', 'SiteWaterSourceController@massDestroy')->name('site-water-sources.massDestroy');
    Route::post('site-water-sources/parse-csv-import', 'SiteWaterSourceController@parseCsvImport')->name('site-water-sources.parseCsvImport');
    Route::post('site-water-sources/process-csv-import', 'SiteWaterSourceController@processCsvImport')->name('site-water-sources.processCsvImport');
    Route::resource('site-water-sources', 'SiteWaterSourceController');

    // Site Weather
    Route::delete('site-weathers/destroy', 'SiteWeatherController@massDestroy')->name('site-weathers.massDestroy');
    Route::post('site-weathers/parse-csv-import', 'SiteWeatherController@parseCsvImport')->name('site-weathers.parseCsvImport');
    Route::post('site-weathers/process-csv-import', 'SiteWeatherController@processCsvImport')->name('site-weathers.processCsvImport');
    Route::resource('site-weathers', 'SiteWeatherController');

    // Cashflow Expense Categories
    Route::delete('cashflow-expense-categories/destroy', 'CashflowExpenseCategoriesController@massDestroy')->name('cashflow-expense-categories.massDestroy');
    Route::post('cashflow-expense-categories/parse-csv-import', 'CashflowExpenseCategoriesController@parseCsvImport')->name('cashflow-expense-categories.parseCsvImport');
    Route::post('cashflow-expense-categories/process-csv-import', 'CashflowExpenseCategoriesController@processCsvImport')->name('cashflow-expense-categories.processCsvImport');
    Route::resource('cashflow-expense-categories', 'CashflowExpenseCategoriesController');

    // Cashflow Income
    Route::delete('cashflow-incomes/destroy', 'CashflowIncomeController@massDestroy')->name('cashflow-incomes.massDestroy');
    Route::post('cashflow-incomes/media', 'CashflowIncomeController@storeMedia')->name('cashflow-incomes.storeMedia');
    Route::post('cashflow-incomes/ckmedia', 'CashflowIncomeController@storeCKEditorImages')->name('cashflow-incomes.storeCKEditorImages');
    Route::post('cashflow-incomes/parse-csv-import', 'CashflowIncomeController@parseCsvImport')->name('cashflow-incomes.parseCsvImport');
    Route::post('cashflow-incomes/process-csv-import', 'CashflowIncomeController@processCsvImport')->name('cashflow-incomes.processCsvImport');
    Route::resource('cashflow-incomes', 'CashflowIncomeController');

    // Cashflow Expense
    Route::delete('cashflow-expenses/destroy', 'CashflowExpenseController@massDestroy')->name('cashflow-expenses.massDestroy');
    Route::post('cashflow-expenses/media', 'CashflowExpenseController@storeMedia')->name('cashflow-expenses.storeMedia');
    Route::post('cashflow-expenses/ckmedia', 'CashflowExpenseController@storeCKEditorImages')->name('cashflow-expenses.storeCKEditorImages');
    Route::post('cashflow-expenses/parse-csv-import', 'CashflowExpenseController@parseCsvImport')->name('cashflow-expenses.parseCsvImport');
    Route::post('cashflow-expenses/process-csv-import', 'CashflowExpenseController@processCsvImport')->name('cashflow-expenses.processCsvImport');
    Route::resource('cashflow-expenses', 'CashflowExpenseController');

    // Cashflow Income Category
    Route::delete('cashflow-income-categories/destroy', 'CashflowIncomeCategoryController@massDestroy')->name('cashflow-income-categories.massDestroy');
    Route::post('cashflow-income-categories/parse-csv-import', 'CashflowIncomeCategoryController@parseCsvImport')->name('cashflow-income-categories.parseCsvImport');
    Route::post('cashflow-income-categories/process-csv-import', 'CashflowIncomeCategoryController@processCsvImport')->name('cashflow-income-categories.processCsvImport');
    Route::resource('cashflow-income-categories', 'CashflowIncomeCategoryController');

    // Employee Job Desc
    Route::delete('employee-job-descs/destroy', 'EmployeeJobDescController@massDestroy')->name('employee-job-descs.massDestroy');
    Route::post('employee-job-descs/media', 'EmployeeJobDescController@storeMedia')->name('employee-job-descs.storeMedia');
    Route::post('employee-job-descs/ckmedia', 'EmployeeJobDescController@storeCKEditorImages')->name('employee-job-descs.storeCKEditorImages');
    Route::post('employee-job-descs/parse-csv-import', 'EmployeeJobDescController@parseCsvImport')->name('employee-job-descs.parseCsvImport');
    Route::post('employee-job-descs/process-csv-import', 'EmployeeJobDescController@processCsvImport')->name('employee-job-descs.processCsvImport');
    Route::resource('employee-job-descs', 'EmployeeJobDescController');

    // Admin Plan
    Route::delete('admin-plans/destroy', 'AdminPlanController@massDestroy')->name('admin-plans.massDestroy');
    Route::post('admin-plans/media', 'AdminPlanController@storeMedia')->name('admin-plans.storeMedia');
    Route::post('admin-plans/ckmedia', 'AdminPlanController@storeCKEditorImages')->name('admin-plans.storeCKEditorImages');
    Route::resource('admin-plans', 'AdminPlanController');

    // Admin Setting
    Route::delete('admin-settings/destroy', 'AdminSettingController@massDestroy')->name('admin-settings.massDestroy');
    Route::post('admin-settings/media', 'AdminSettingController@storeMedia')->name('admin-settings.storeMedia');
    Route::post('admin-settings/ckmedia', 'AdminSettingController@storeCKEditorImages')->name('admin-settings.storeCKEditorImages');
    Route::post('admin-settings/parse-csv-import', 'AdminSettingController@parseCsvImport')->name('admin-settings.parseCsvImport');
    Route::post('admin-settings/process-csv-import', 'AdminSettingController@processCsvImport')->name('admin-settings.processCsvImport');
    Route::resource('admin-settings', 'AdminSettingController');

    // Admin Info
    Route::delete('admin-infos/destroy', 'AdminInfoController@massDestroy')->name('admin-infos.massDestroy');
    Route::post('admin-infos/media', 'AdminInfoController@storeMedia')->name('admin-infos.storeMedia');
    Route::post('admin-infos/ckmedia', 'AdminInfoController@storeCKEditorImages')->name('admin-infos.storeCKEditorImages');
    Route::resource('admin-infos', 'AdminInfoController');

    // Admin Database
    Route::delete('admin-databases/destroy', 'AdminDatabaseController@massDestroy')->name('admin-databases.massDestroy');
    Route::post('admin-databases/media', 'AdminDatabaseController@storeMedia')->name('admin-databases.storeMedia');
    Route::post('admin-databases/ckmedia', 'AdminDatabaseController@storeCKEditorImages')->name('admin-databases.storeCKEditorImages');
    Route::resource('admin-databases', 'AdminDatabaseController');

    // Admin Category
    Route::delete('admin-categories/destroy', 'AdminCategoryController@massDestroy')->name('admin-categories.massDestroy');
    Route::post('admin-categories/media', 'AdminCategoryController@storeMedia')->name('admin-categories.storeMedia');
    Route::post('admin-categories/ckmedia', 'AdminCategoryController@storeCKEditorImages')->name('admin-categories.storeCKEditorImages');
    Route::resource('admin-categories', 'AdminCategoryController');

    // Admin Tag
    Route::delete('admin-tags/destroy', 'AdminTagController@massDestroy')->name('admin-tags.massDestroy');
    Route::resource('admin-tags', 'AdminTagController');

    // Admin Expert
    Route::delete('admin-experts/destroy', 'AdminExpertController@massDestroy')->name('admin-experts.massDestroy');
    Route::post('admin-experts/media', 'AdminExpertController@storeMedia')->name('admin-experts.storeMedia');
    Route::post('admin-experts/ckmedia', 'AdminExpertController@storeCKEditorImages')->name('admin-experts.storeCKEditorImages');
    Route::resource('admin-experts', 'AdminExpertController');

    // Team
    Route::delete('teams/destroy', 'TeamController@massDestroy')->name('teams.massDestroy');
    Route::resource('teams', 'TeamController');

    // Cashflow Sales
    Route::delete('cashflow-sales/destroy', 'CashflowSalesController@massDestroy')->name('cashflow-sales.massDestroy');
    Route::post('cashflow-sales/media', 'CashflowSalesController@storeMedia')->name('cashflow-sales.storeMedia');
    Route::post('cashflow-sales/ckmedia', 'CashflowSalesController@storeCKEditorImages')->name('cashflow-sales.storeCKEditorImages');
    Route::post('cashflow-sales/parse-csv-import', 'CashflowSalesController@parseCsvImport')->name('cashflow-sales.parseCsvImport');
    Route::post('cashflow-sales/process-csv-import', 'CashflowSalesController@processCsvImport')->name('cashflow-sales.processCsvImport');
    Route::resource('cashflow-sales', 'CashflowSalesController');

    // Cashflow Purchase
    Route::delete('cashflow-purchases/destroy', 'CashflowPurchaseController@massDestroy')->name('cashflow-purchases.massDestroy');
    Route::post('cashflow-purchases/media', 'CashflowPurchaseController@storeMedia')->name('cashflow-purchases.storeMedia');
    Route::post('cashflow-purchases/ckmedia', 'CashflowPurchaseController@storeCKEditorImages')->name('cashflow-purchases.storeCKEditorImages');
    Route::post('cashflow-purchases/parse-csv-import', 'CashflowPurchaseController@parseCsvImport')->name('cashflow-purchases.parseCsvImport');
    Route::post('cashflow-purchases/process-csv-import', 'CashflowPurchaseController@processCsvImport')->name('cashflow-purchases.processCsvImport');
    Route::resource('cashflow-purchases', 'CashflowPurchaseController');

    // Plot
    Route::delete('plots/destroy', 'PlotController@massDestroy')->name('plots.massDestroy');
    Route::post('plots/media', 'PlotController@storeMedia')->name('plots.storeMedia');
    Route::post('plots/ckmedia', 'PlotController@storeCKEditorImages')->name('plots.storeCKEditorImages');
    Route::post('plots/parse-csv-import', 'PlotController@parseCsvImport')->name('plots.parseCsvImport');
    Route::post('plots/process-csv-import', 'PlotController@processCsvImport')->name('plots.processCsvImport');
    Route::resource('plots', 'PlotController');

    // Plot Plant
    Route::delete('plot-plants/destroy', 'PlotPlantController@massDestroy')->name('plot-plants.massDestroy');
    Route::post('plot-plants/parse-csv-import', 'PlotPlantController@parseCsvImport')->name('plot-plants.parseCsvImport');
    Route::post('plot-plants/process-csv-import', 'PlotPlantController@processCsvImport')->name('plot-plants.processCsvImport');
    Route::resource('plot-plants', 'PlotPlantController');

    // Plot Stage
    Route::delete('plot-stages/destroy', 'PlotStageController@massDestroy')->name('plot-stages.massDestroy');
    Route::post('plot-stages/parse-csv-import', 'PlotStageController@parseCsvImport')->name('plot-stages.parseCsvImport');
    Route::post('plot-stages/process-csv-import', 'PlotStageController@processCsvImport')->name('plot-stages.processCsvImport');
    Route::resource('plot-stages', 'PlotStageController');

    // Plot Variety
    Route::delete('plot-varieties/destroy', 'PlotVarietyController@massDestroy')->name('plot-varieties.massDestroy');
    Route::post('plot-varieties/parse-csv-import', 'PlotVarietyController@parseCsvImport')->name('plot-varieties.parseCsvImport');
    Route::post('plot-varieties/process-csv-import', 'PlotVarietyController@processCsvImport')->name('plot-varieties.processCsvImport');
    Route::resource('plot-varieties', 'PlotVarietyController');

    // Plot Codes
    Route::delete('plot-codes/destroy', 'PlotCodesController@massDestroy')->name('plot-codes.massDestroy');
    Route::post('plot-codes/parse-csv-import', 'PlotCodesController@parseCsvImport')->name('plot-codes.parseCsvImport');
    Route::post('plot-codes/process-csv-import', 'PlotCodesController@processCsvImport')->name('plot-codes.processCsvImport');
    Route::resource('plot-codes', 'PlotCodesController');

    // Care Harvest
    Route::delete('care-harvests/destroy', 'CareHarvestController@massDestroy')->name('care-harvests.massDestroy');
    Route::post('care-harvests/media', 'CareHarvestController@storeMedia')->name('care-harvests.storeMedia');
    Route::post('care-harvests/ckmedia', 'CareHarvestController@storeCKEditorImages')->name('care-harvests.storeCKEditorImages');
    Route::post('care-harvests/parse-csv-import', 'CareHarvestController@parseCsvImport')->name('care-harvests.parseCsvImport');
    Route::post('care-harvests/process-csv-import', 'CareHarvestController@processCsvImport')->name('care-harvests.processCsvImport');
    Route::resource('care-harvests', 'CareHarvestController');

    // Care Packing
    Route::delete('care-packings/destroy', 'CarePackingController@massDestroy')->name('care-packings.massDestroy');
    Route::post('care-packings/media', 'CarePackingController@storeMedia')->name('care-packings.storeMedia');
    Route::post('care-packings/ckmedia', 'CarePackingController@storeCKEditorImages')->name('care-packings.storeCKEditorImages');
    Route::post('care-packings/parse-csv-import', 'CarePackingController@parseCsvImport')->name('care-packings.parseCsvImport');
    Route::post('care-packings/process-csv-import', 'CarePackingController@processCsvImport')->name('care-packings.processCsvImport');
    Route::resource('care-packings', 'CarePackingController');

    // Care Distribution
    Route::delete('care-distributions/destroy', 'CareDistributionController@massDestroy')->name('care-distributions.massDestroy');
    Route::post('care-distributions/media', 'CareDistributionController@storeMedia')->name('care-distributions.storeMedia');
    Route::post('care-distributions/ckmedia', 'CareDistributionController@storeCKEditorImages')->name('care-distributions.storeCKEditorImages');
    Route::post('care-distributions/parse-csv-import', 'CareDistributionController@parseCsvImport')->name('care-distributions.parseCsvImport');
    Route::post('care-distributions/process-csv-import', 'CareDistributionController@processCsvImport')->name('care-distributions.processCsvImport');
    Route::resource('care-distributions', 'CareDistributionController');

    // Care Module
    Route::delete('care-modules/destroy', 'CareModuleController@massDestroy')->name('care-modules.massDestroy');
    Route::post('care-modules/media', 'CareModuleController@storeMedia')->name('care-modules.storeMedia');
    Route::post('care-modules/ckmedia', 'CareModuleController@storeCKEditorImages')->name('care-modules.storeCKEditorImages');
    Route::post('care-modules/parse-csv-import', 'CareModuleController@parseCsvImport')->name('care-modules.parseCsvImport');
    Route::post('care-modules/process-csv-import', 'CareModuleController@processCsvImport')->name('care-modules.processCsvImport');
    Route::resource('care-modules', 'CareModuleController');

    // Care Site
    Route::delete('care-sites/destroy', 'CareSiteController@massDestroy')->name('care-sites.massDestroy');
    Route::post('care-sites/media', 'CareSiteController@storeMedia')->name('care-sites.storeMedia');
    Route::post('care-sites/ckmedia', 'CareSiteController@storeCKEditorImages')->name('care-sites.storeCKEditorImages');
    Route::post('care-sites/parse-csv-import', 'CareSiteController@parseCsvImport')->name('care-sites.parseCsvImport');
    Route::post('care-sites/process-csv-import', 'CareSiteController@processCsvImport')->name('care-sites.processCsvImport');
    Route::resource('care-sites', 'CareSiteController');

    // Care Plant Assessment
    Route::delete('care-plant-assessments/destroy', 'CarePlantAssessmentController@massDestroy')->name('care-plant-assessments.massDestroy');
    Route::post('care-plant-assessments/media', 'CarePlantAssessmentController@storeMedia')->name('care-plant-assessments.storeMedia');
    Route::post('care-plant-assessments/ckmedia', 'CarePlantAssessmentController@storeCKEditorImages')->name('care-plant-assessments.storeCKEditorImages');
    Route::post('care-plant-assessments/parse-csv-import', 'CarePlantAssessmentController@parseCsvImport')->name('care-plant-assessments.parseCsvImport');
    Route::post('care-plant-assessments/process-csv-import', 'CarePlantAssessmentController@processCsvImport')->name('care-plant-assessments.processCsvImport');
    Route::resource('care-plant-assessments', 'CarePlantAssessmentController');

    // Care Nutrient Control
    Route::delete('care-nutrient-controls/destroy', 'CareNutrientControlController@massDestroy')->name('care-nutrient-controls.massDestroy');
    Route::post('care-nutrient-controls/media', 'CareNutrientControlController@storeMedia')->name('care-nutrient-controls.storeMedia');
    Route::post('care-nutrient-controls/ckmedia', 'CareNutrientControlController@storeCKEditorImages')->name('care-nutrient-controls.storeCKEditorImages');
    Route::post('care-nutrient-controls/parse-csv-import', 'CareNutrientControlController@parseCsvImport')->name('care-nutrient-controls.parseCsvImport');
    Route::post('care-nutrient-controls/process-csv-import', 'CareNutrientControlController@processCsvImport')->name('care-nutrient-controls.processCsvImport');
    Route::resource('care-nutrient-controls', 'CareNutrientControlController');

    // Care Sale
    Route::delete('care-sales/destroy', 'CareSaleController@massDestroy')->name('care-sales.massDestroy');
    Route::post('care-sales/media', 'CareSaleController@storeMedia')->name('care-sales.storeMedia');
    Route::post('care-sales/ckmedia', 'CareSaleController@storeCKEditorImages')->name('care-sales.storeCKEditorImages');
    Route::post('care-sales/parse-csv-import', 'CareSaleController@parseCsvImport')->name('care-sales.parseCsvImport');
    Route::post('care-sales/process-csv-import', 'CareSaleController@processCsvImport')->name('care-sales.processCsvImport');
    Route::resource('care-sales', 'CareSaleController');

    // Care Purchase
    Route::delete('care-purchases/destroy', 'CarePurchaseController@massDestroy')->name('care-purchases.massDestroy');
    Route::post('care-purchases/media', 'CarePurchaseController@storeMedia')->name('care-purchases.storeMedia');
    Route::post('care-purchases/ckmedia', 'CarePurchaseController@storeCKEditorImages')->name('care-purchases.storeCKEditorImages');
    Route::post('care-purchases/parse-csv-import', 'CarePurchaseController@parseCsvImport')->name('care-purchases.parseCsvImport');
    Route::post('care-purchases/process-csv-import', 'CarePurchaseController@processCsvImport')->name('care-purchases.processCsvImport');
    Route::resource('care-purchases', 'CarePurchaseController');

    // Care List Page
    Route::delete('care-list-pages/destroy', 'CareListPageController@massDestroy')->name('care-list-pages.massDestroy');
    Route::resource('care-list-pages', 'CareListPageController');

    // Employee Attendance
    Route::delete('employee-attendances/destroy', 'EmployeeAttendanceController@massDestroy')->name('employee-attendances.massDestroy');
    Route::post('employee-attendances/media', 'EmployeeAttendanceController@storeMedia')->name('employee-attendances.storeMedia');
    Route::post('employee-attendances/ckmedia', 'EmployeeAttendanceController@storeCKEditorImages')->name('employee-attendances.storeCKEditorImages');
    Route::post('employee-attendances/parse-csv-import', 'EmployeeAttendanceController@parseCsvImport')->name('employee-attendances.parseCsvImport');
    Route::post('employee-attendances/process-csv-import', 'EmployeeAttendanceController@processCsvImport')->name('employee-attendances.processCsvImport');
    Route::resource('employee-attendances', 'EmployeeAttendanceController');

    // Employee Leave
    Route::delete('employee-leaves/destroy', 'EmployeeLeaveController@massDestroy')->name('employee-leaves.massDestroy');
    Route::post('employee-leaves/parse-csv-import', 'EmployeeLeaveController@parseCsvImport')->name('employee-leaves.parseCsvImport');
    Route::post('employee-leaves/process-csv-import', 'EmployeeLeaveController@processCsvImport')->name('employee-leaves.processCsvImport');
    Route::resource('employee-leaves', 'EmployeeLeaveController');

    // Emp Leave Type
    Route::delete('emp-leave-types/destroy', 'EmpLeaveTypeController@massDestroy')->name('emp-leave-types.massDestroy');
    Route::resource('emp-leave-types', 'EmpLeaveTypeController');

    // Task
    Route::delete('tasks/destroy', 'TaskController@massDestroy')->name('tasks.massDestroy');
    Route::post('tasks/media', 'TaskController@storeMedia')->name('tasks.storeMedia');
    Route::post('tasks/ckmedia', 'TaskController@storeCKEditorImages')->name('tasks.storeCKEditorImages');
    Route::resource('tasks', 'TaskController');

    // Faq Category
    Route::delete('faq-categories/destroy', 'FaqCategoryController@massDestroy')->name('faq-categories.massDestroy');
    Route::resource('faq-categories', 'FaqCategoryController');

    // Faq Question
    Route::delete('faq-questions/destroy', 'FaqQuestionController@massDestroy')->name('faq-questions.massDestroy');
    Route::resource('faq-questions', 'FaqQuestionController');

    // Audit Logs
    Route::resource('audit-logs', 'AuditLogsController', ['except' => ['create', 'store', 'edit', 'update', 'destroy']]);

    // Sales Payment
    Route::delete('sales-payments/destroy', 'SalesPaymentController@massDestroy')->name('sales-payments.massDestroy');
    Route::post('sales-payments/parse-csv-import', 'SalesPaymentController@parseCsvImport')->name('sales-payments.parseCsvImport');
    Route::post('sales-payments/process-csv-import', 'SalesPaymentController@processCsvImport')->name('sales-payments.processCsvImport');
    Route::resource('sales-payments', 'SalesPaymentController');

    Route::get('system-calendar', 'SystemCalendarController@index')->name('systemCalendar');
    Route::get('messenger', 'MessengerController@index')->name('messenger.index');
    Route::get('messenger/create', 'MessengerController@createTopic')->name('messenger.createTopic');
    Route::post('messenger', 'MessengerController@storeTopic')->name('messenger.storeTopic');
    Route::get('messenger/inbox', 'MessengerController@showInbox')->name('messenger.showInbox');
    Route::get('messenger/outbox', 'MessengerController@showOutbox')->name('messenger.showOutbox');
    Route::get('messenger/{topic}', 'MessengerController@showMessages')->name('messenger.showMessages');
    Route::delete('messenger/{topic}', 'MessengerController@destroyTopic')->name('messenger.destroyTopic');
    Route::post('messenger/{topic}/reply', 'MessengerController@replyToTopic')->name('messenger.reply');
    Route::get('messenger/{topic}/reply', 'MessengerController@showReply')->name('messenger.showReply');
    Route::get('team-members', 'TeamMembersController@index')->name('team-members.index');
    Route::post('team-members', 'TeamMembersController@invite')->name('team-members.invite');
});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth', '2fa']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
        Route::post('profile/two-factor', 'ChangePasswordController@toggleTwoFactor')->name('password.toggleTwoFactor');
    }
});
Route::group(['namespace' => 'Auth', 'middleware' => ['auth', '2fa']], function () {
    // Two Factor Authentication
    if (file_exists(app_path('Http/Controllers/Auth/TwoFactorController.php'))) {
        Route::get('two-factor', 'TwoFactorController@show')->name('twoFactor.show');
        Route::post('two-factor', 'TwoFactorController@check')->name('twoFactor.check');
        Route::get('two-factor/resend', 'TwoFactorController@resend')->name('twoFactor.resend');
    }
});
