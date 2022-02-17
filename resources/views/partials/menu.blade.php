<div id="sidebar" class="c-sidebar c-sidebar-fixed c-sidebar-lg-show">

    <div class="c-sidebar-brand d-md-down-none">
        <a class="c-sidebar-brand-full h4" href="#">
            {{ trans('panel.site_title') }}
        </a>
    </div>

    <ul class="c-sidebar-nav">
        <li class="c-sidebar-nav-item">
            <a href="{{ route("admin.home") }}" class="c-sidebar-nav-link">
                <i class="c-sidebar-nav-icon fas fa-fw fa-tachometer-alt">

                </i>
                {{ trans('global.dashboard') }}
            </a>
        </li>
        @can('task_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.tasks.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/tasks") || request()->is("admin/tasks/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-tasks c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.task.title') }}
                </a>
            </li>
        @endcan
        @can('plant_assessment_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.plant-assessments.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/plant-assessments") || request()->is("admin/plant-assessments/*") ? "c-active" : "" }}">
                    <i class="fa-fw fab fa-envira c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.plantAssessment.title') }}
                </a>
            </li>
        @endcan
        @can('nutrient_control_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.nutrient-controls.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/nutrient-controls") || request()->is("admin/nutrient-controls/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-fill-drip c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.nutrientControl.title') }}
                </a>
            </li>
        @endcan
        @can('module_observation_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.module-observations.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/module-observations") || request()->is("admin/module-observations/*") ? "c-active" : "" }}">
                    <i class="fa-fw far fa-list-alt c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.moduleObservation.title') }}
                </a>
            </li>
        @endcan
        @can('site_inspection_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.site-inspections.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/site-inspections") || request()->is("admin/site-inspections/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-map-marker-alt c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.siteInspection.title') }}
                </a>
            </li>
        @endcan
        @can('field_management_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/sites*") ? "c-show" : "" }} {{ request()->is("admin/modules*") ? "c-show" : "" }} {{ request()->is("admin/plots*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-sitemap c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.fieldManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('site_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.sites.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/sites") || request()->is("admin/sites/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-genderless c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.site.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('module_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.modules.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/modules") || request()->is("admin/modules/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-genderless c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.module.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('plot_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.plots.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/plots") || request()->is("admin/plots/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-genderless c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.plot.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('post_production_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/harvests*") ? "c-show" : "" }} {{ request()->is("admin/packings*") ? "c-show" : "" }} {{ request()->is("admin/distributions*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-external-link-alt c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.postProduction.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('harvest_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.harvests.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/harvests") || request()->is("admin/harvests/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-genderless c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.harvest.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('packing_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.packings.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/packings") || request()->is("admin/packings/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-genderless c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.packing.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('distribution_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.distributions.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/distributions") || request()->is("admin/distributions/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-genderless c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.distribution.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('care_list_page_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.care-list-pages.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/care-list-pages") || request()->is("admin/care-list-pages/*") ? "c-active" : "" }}">
                    <i class="fa-fw far fa-heart c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.careListPage.title') }}
                </a>
            </li>
        @endcan
        @can('care_center_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/care-pre-orders*") ? "c-show" : "" }} {{ request()->is("admin/care-plant-assessments*") ? "c-show" : "" }} {{ request()->is("admin/care-nutrient-controls*") ? "c-show" : "" }} {{ request()->is("admin/care-modules*") ? "c-show" : "" }} {{ request()->is("admin/care-sites*") ? "c-show" : "" }} {{ request()->is("admin/care-harvests*") ? "c-show" : "" }} {{ request()->is("admin/care-packings*") ? "c-show" : "" }} {{ request()->is("admin/care-distributions*") ? "c-show" : "" }} {{ request()->is("admin/care-sales*") ? "c-show" : "" }} {{ request()->is("admin/care-purchases*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-stethoscope c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.careCenter.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('care_pre_order_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.care-pre-orders.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/care-pre-orders") || request()->is("admin/care-pre-orders/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-genderless c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.carePreOrder.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('care_plant_assessment_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.care-plant-assessments.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/care-plant-assessments") || request()->is("admin/care-plant-assessments/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-genderless c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.carePlantAssessment.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('care_nutrient_control_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.care-nutrient-controls.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/care-nutrient-controls") || request()->is("admin/care-nutrient-controls/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-genderless c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.careNutrientControl.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('care_module_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.care-modules.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/care-modules") || request()->is("admin/care-modules/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-genderless c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.careModule.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('care_site_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.care-sites.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/care-sites") || request()->is("admin/care-sites/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-genderless c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.careSite.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('care_harvest_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.care-harvests.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/care-harvests") || request()->is("admin/care-harvests/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-genderless c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.careHarvest.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('care_packing_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.care-packings.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/care-packings") || request()->is("admin/care-packings/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-genderless c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.carePacking.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('care_distribution_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.care-distributions.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/care-distributions") || request()->is("admin/care-distributions/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-genderless c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.careDistribution.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('care_sale_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.care-sales.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/care-sales") || request()->is("admin/care-sales/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-genderless c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.careSale.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('care_purchase_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.care-purchases.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/care-purchases") || request()->is("admin/care-purchases/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-genderless c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.carePurchase.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('cashflow_management_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/cashflow-income-categories*") ? "c-show" : "" }} {{ request()->is("admin/cashflow-expense-categories*") ? "c-show" : "" }} {{ request()->is("admin/cashflow-expenses*") ? "c-show" : "" }} {{ request()->is("admin/cashflow-incomes*") ? "c-show" : "" }} {{ request()->is("admin/cashflow-sales*") ? "c-show" : "" }} {{ request()->is("admin/cashflow-purchases*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-money-bill-wave c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.cashflowManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('cashflow_income_category_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.cashflow-income-categories.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/cashflow-income-categories") || request()->is("admin/cashflow-income-categories/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-genderless c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.cashflowIncomeCategory.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('cashflow_expense_category_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.cashflow-expense-categories.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/cashflow-expense-categories") || request()->is("admin/cashflow-expense-categories/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-genderless c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.cashflowExpenseCategory.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('cashflow_expense_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.cashflow-expenses.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/cashflow-expenses") || request()->is("admin/cashflow-expenses/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-genderless c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.cashflowExpense.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('cashflow_income_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.cashflow-incomes.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/cashflow-incomes") || request()->is("admin/cashflow-incomes/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-genderless c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.cashflowIncome.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('cashflow_sale_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.cashflow-sales.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/cashflow-sales") || request()->is("admin/cashflow-sales/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-genderless c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.cashflowSale.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('cashflow_purchase_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.cashflow-purchases.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/cashflow-purchases") || request()->is("admin/cashflow-purchases/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-genderless c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.cashflowPurchase.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('sales_management_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/sales-customers*") ? "c-show" : "" }} {{ request()->is("admin/sales-channels*") ? "c-show" : "" }} {{ request()->is("admin/sales-deliveries*") ? "c-show" : "" }} {{ request()->is("admin/sales-labels*") ? "c-show" : "" }} {{ request()->is("admin/sales-markets*") ? "c-show" : "" }} {{ request()->is("admin/sales-payments*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-chart-line c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.salesManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('sales_customer_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.sales-customers.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/sales-customers") || request()->is("admin/sales-customers/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-genderless c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.salesCustomer.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('sales_channel_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.sales-channels.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/sales-channels") || request()->is("admin/sales-channels/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-genderless c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.salesChannel.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('sales_delivery_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.sales-deliveries.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/sales-deliveries") || request()->is("admin/sales-deliveries/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-genderless c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.salesDelivery.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('sales_label_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.sales-labels.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/sales-labels") || request()->is("admin/sales-labels/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-genderless c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.salesLabel.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('sales_market_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.sales-markets.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/sales-markets") || request()->is("admin/sales-markets/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-genderless c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.salesMarket.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('sales_payment_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.sales-payments.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/sales-payments") || request()->is("admin/sales-payments/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-genderless c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.salesPayment.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('purchase_management_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/purchase-brands*") ? "c-show" : "" }} {{ request()->is("admin/purchase-companies*") ? "c-show" : "" }} {{ request()->is("admin/purchase-contacts*") ? "c-show" : "" }} {{ request()->is("admin/purchase-equipments*") ? "c-show" : "" }} {{ request()->is("admin/purchase-substances*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-luggage-cart c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.purchaseManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('purchase_brand_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.purchase-brands.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/purchase-brands") || request()->is("admin/purchase-brands/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-genderless c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.purchaseBrand.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('purchase_company_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.purchase-companies.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/purchase-companies") || request()->is("admin/purchase-companies/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-genderless c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.purchaseCompany.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('purchase_contact_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.purchase-contacts.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/purchase-contacts") || request()->is("admin/purchase-contacts/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-genderless c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.purchaseContact.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('purchase_equipment_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.purchase-equipments.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/purchase-equipments") || request()->is("admin/purchase-equipments/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-genderless c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.purchaseEquipment.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('purchase_substance_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.purchase-substances.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/purchase-substances") || request()->is("admin/purchase-substances/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-genderless c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.purchaseSubstance.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('employee_management_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/employee-job-descs*") ? "c-show" : "" }} {{ request()->is("admin/employee-positions*") ? "c-show" : "" }} {{ request()->is("admin/employee-statuses*") ? "c-show" : "" }} {{ request()->is("admin/emp-leave-types*") ? "c-show" : "" }} {{ request()->is("admin/employees*") ? "c-show" : "" }} {{ request()->is("admin/employee-attendances*") ? "c-show" : "" }} {{ request()->is("admin/employee-leaves*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fab fa-black-tie c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.employeeManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('employee_job_desc_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.employee-job-descs.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/employee-job-descs") || request()->is("admin/employee-job-descs/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-genderless c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.employeeJobDesc.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('employee_position_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.employee-positions.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/employee-positions") || request()->is("admin/employee-positions/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-genderless c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.employeePosition.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('employee_status_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.employee-statuses.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/employee-statuses") || request()->is("admin/employee-statuses/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-genderless c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.employeeStatus.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('emp_leave_type_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.emp-leave-types.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/emp-leave-types") || request()->is("admin/emp-leave-types/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-genderless c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.empLeaveType.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('employee_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.employees.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/employees") || request()->is("admin/employees/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-genderless c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.employee.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('employee_attendance_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.employee-attendances.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/employee-attendances") || request()->is("admin/employee-attendances/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-genderless c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.employeeAttendance.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('employee_leave_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.employee-leaves.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/employee-leaves") || request()->is("admin/employee-leaves/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-genderless c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.employeeLeave.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('site_management_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/site-settings*") ? "c-show" : "" }} {{ request()->is("admin/site-water-sources*") ? "c-show" : "" }} {{ request()->is("admin/site-weathers*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-map-marked-alt c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.siteManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('site_setting_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.site-settings.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/site-settings") || request()->is("admin/site-settings/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-genderless c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.siteSetting.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('site_water_source_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.site-water-sources.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/site-water-sources") || request()->is("admin/site-water-sources/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-genderless c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.siteWaterSource.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('site_weather_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.site-weathers.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/site-weathers") || request()->is("admin/site-weathers/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-genderless c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.siteWeather.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('module_management_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/module-activities*") ? "c-show" : "" }} {{ request()->is("admin/module-components*") ? "c-show" : "" }} {{ request()->is("admin/module-systems*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-grip-horizontal c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.moduleManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('module_activity_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.module-activities.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/module-activities") || request()->is("admin/module-activities/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-genderless c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.moduleActivity.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('module_component_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.module-components.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/module-components") || request()->is("admin/module-components/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-genderless c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.moduleComponent.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('module_system_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.module-systems.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/module-systems") || request()->is("admin/module-systems/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-genderless c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.moduleSystem.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('plot_management_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/plot-plants*") ? "c-show" : "" }} {{ request()->is("admin/plot-stages*") ? "c-show" : "" }} {{ request()->is("admin/plot-varieties*") ? "c-show" : "" }} {{ request()->is("admin/plot-codes*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-seedling c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.plotManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('plot_plant_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.plot-plants.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/plot-plants") || request()->is("admin/plot-plants/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-genderless c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.plotPlant.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('plot_stage_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.plot-stages.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/plot-stages") || request()->is("admin/plot-stages/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-genderless c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.plotStage.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('plot_variety_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.plot-varieties.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/plot-varieties") || request()->is("admin/plot-varieties/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-genderless c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.plotVariety.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('plot_code_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.plot-codes.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/plot-codes") || request()->is("admin/plot-codes/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-genderless c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.plotCode.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('unit_management_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/unit-ages*") ? "c-show" : "" }} {{ request()->is("admin/unit-areas*") ? "c-show" : "" }} {{ request()->is("admin/unit-capacities*") ? "c-show" : "" }} {{ request()->is("admin/unit-quantities*") ? "c-show" : "" }} {{ request()->is("admin/unit-temperatures*") ? "c-show" : "" }} {{ request()->is("admin/unit-weights*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-underline c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.unitManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('unit_age_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.unit-ages.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/unit-ages") || request()->is("admin/unit-ages/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-genderless c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.unitAge.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('unit_area_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.unit-areas.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/unit-areas") || request()->is("admin/unit-areas/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-genderless c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.unitArea.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('unit_capacity_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.unit-capacities.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/unit-capacities") || request()->is("admin/unit-capacities/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-genderless c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.unitCapacity.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('unit_quantity_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.unit-quantities.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/unit-quantities") || request()->is("admin/unit-quantities/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-genderless c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.unitQuantity.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('unit_temperature_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.unit-temperatures.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/unit-temperatures") || request()->is("admin/unit-temperatures/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-genderless c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.unitTemperature.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('unit_weight_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.unit-weights.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/unit-weights") || request()->is("admin/unit-weights/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-genderless c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.unitWeight.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('attribute_management_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/att-categories*") ? "c-show" : "" }} {{ request()->is("admin/att-category-comps*") ? "c-show" : "" }} {{ request()->is("admin/att-efficacies*") ? "c-show" : "" }} {{ request()->is("admin/product-grades*") ? "c-show" : "" }} {{ request()->is("admin/att-priorities*") ? "c-show" : "" }} {{ request()->is("admin/att-statuses*") ? "c-show" : "" }} {{ request()->is("admin/att-tags*") ? "c-show" : "" }} {{ request()->is("admin/att-types*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-sitemap c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.attributeManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('att_category_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.att-categories.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/att-categories") || request()->is("admin/att-categories/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-genderless c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.attCategory.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('att_category_comp_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.att-category-comps.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/att-category-comps") || request()->is("admin/att-category-comps/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-genderless c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.attCategoryComp.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('att_efficacy_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.att-efficacies.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/att-efficacies") || request()->is("admin/att-efficacies/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-genderless c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.attEfficacy.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('product_grade_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.product-grades.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/product-grades") || request()->is("admin/product-grades/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-genderless c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.productGrade.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('att_priority_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.att-priorities.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/att-priorities") || request()->is("admin/att-priorities/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-genderless c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.attPriority.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('att_status_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.att-statuses.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/att-statuses") || request()->is("admin/att-statuses/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-genderless c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.attStatus.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('att_tag_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.att-tags.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/att-tags") || request()->is("admin/att-tags/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-genderless c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.attTag.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('att_type_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.att-types.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/att-types") || request()->is("admin/att-types/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-genderless c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.attType.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('business_setting_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.business-settings.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/business-settings") || request()->is("admin/business-settings/*") ? "c-active" : "" }}">
                    <i class="fa-fw far fa-sun c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.businessSetting.title') }}
                </a>
            </li>
        @endcan
        @can('user_alert_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.user-alerts.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/user-alerts") || request()->is("admin/user-alerts/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-bell c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.userAlert.title') }}
                </a>
            </li>
        @endcan
        @can('administrator_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/admin-plans*") ? "c-show" : "" }} {{ request()->is("admin/admin-categories*") ? "c-show" : "" }} {{ request()->is("admin/admin-databases*") ? "c-show" : "" }} {{ request()->is("admin/admin-experts*") ? "c-show" : "" }} {{ request()->is("admin/admin-infos*") ? "c-show" : "" }} {{ request()->is("admin/admin-settings*") ? "c-show" : "" }} {{ request()->is("admin/admin-tags*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-chalkboard-teacher c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.administrator.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('admin_plan_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.admin-plans.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/admin-plans") || request()->is("admin/admin-plans/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-genderless c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.adminPlan.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('admin_category_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.admin-categories.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/admin-categories") || request()->is("admin/admin-categories/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-genderless c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.adminCategory.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('admin_database_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.admin-databases.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/admin-databases") || request()->is("admin/admin-databases/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-genderless c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.adminDatabase.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('admin_expert_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.admin-experts.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/admin-experts") || request()->is("admin/admin-experts/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-genderless c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.adminExpert.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('admin_info_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.admin-infos.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/admin-infos") || request()->is("admin/admin-infos/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-genderless c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.adminInfo.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('admin_setting_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.admin-settings.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/admin-settings") || request()->is("admin/admin-settings/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-genderless c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.adminSetting.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('admin_tag_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.admin-tags.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/admin-tags") || request()->is("admin/admin-tags/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-genderless c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.adminTag.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('user_management_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/permissions*") ? "c-show" : "" }} {{ request()->is("admin/roles*") ? "c-show" : "" }} {{ request()->is("admin/users*") ? "c-show" : "" }} {{ request()->is("admin/teams*") ? "c-show" : "" }} {{ request()->is("admin/audit-logs*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-users c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.userManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('permission_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.permissions.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/permissions") || request()->is("admin/permissions/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-genderless c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.permission.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('role_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.roles.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/roles") || request()->is("admin/roles/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-genderless c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.role.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('user_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.users.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/users") || request()->is("admin/users/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-genderless c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.user.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('team_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.teams.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/teams") || request()->is("admin/teams/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-genderless c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.team.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('audit_log_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.audit-logs.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/audit-logs") || request()->is("admin/audit-logs/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-file-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.auditLog.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('faq_management_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/faq-categories*") ? "c-show" : "" }} {{ request()->is("admin/faq-questions*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-question c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.faqManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('faq_category_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.faq-categories.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/faq-categories") || request()->is("admin/faq-categories/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-briefcase c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.faqCategory.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('faq_question_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.faq-questions.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/faq-questions") || request()->is("admin/faq-questions/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-question c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.faqQuestion.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        <li class="c-sidebar-nav-item">
            <a href="{{ route("admin.systemCalendar") }}" class="c-sidebar-nav-link {{ request()->is("admin/system-calendar") || request()->is("admin/system-calendar/*") ? "c-active" : "" }}">
                <i class="c-sidebar-nav-icon fa-fw fas fa-calendar">

                </i>
                {{ trans('global.systemCalendar') }}
            </a>
        </li>
        @php($unread = \App\Models\QaTopic::unreadCount())
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.messenger.index") }}" class="{{ request()->is("admin/messenger") || request()->is("admin/messenger/*") ? "c-active" : "" }} c-sidebar-nav-link">
                    <i class="c-sidebar-nav-icon fa-fw fa fa-envelope">

                    </i>
                    <span>{{ trans('global.messages') }}</span>
                    @if($unread > 0)
                        <strong>( {{ $unread }} )</strong>
                    @endif

                </a>
            </li>
            @if(\Illuminate\Support\Facades\Schema::hasColumn('teams', 'owner_id') && \App\Models\Team::where('owner_id', auth()->user()->id)->exists())
                <li class="c-sidebar-nav-item">
                    <a class="{{ request()->is("admin/team-members") || request()->is("admin/team-members/*") ? "c-active" : "" }} c-sidebar-nav-link" href="{{ route("admin.team-members.index") }}">
                        <i class="c-sidebar-nav-icon fa-fw fa fa-users">
                        </i>
                        <span>{{ trans("global.team-members") }}</span>
                    </a>
                </li>
            @endif
            @if(file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php')))
                @can('profile_password_edit')
                    <li class="c-sidebar-nav-item">
                        <a class="c-sidebar-nav-link {{ request()->is('profile/password') || request()->is('profile/password/*') ? 'c-active' : '' }}" href="{{ route('profile.password.edit') }}">
                            <i class="fa-fw fas fa-key c-sidebar-nav-icon">
                            </i>
                            {{ trans('global.change_password') }}
                        </a>
                    </li>
                @endcan
            @endif
            <li class="c-sidebar-nav-item">
                <a href="#" class="c-sidebar-nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                    <i class="c-sidebar-nav-icon fas fa-fw fa-sign-out-alt">

                    </i>
                    {{ trans('global.logout') }}
                </a>
            </li>
    </ul>

</div>