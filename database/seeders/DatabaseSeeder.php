<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            PermissionsTableSeeder::class,
            RolesTableSeeder::class,
            PermissionRoleTableSeeder::class,
            UsersTableSeeder::class,
            RoleUserTableSeeder::class,

            AttCategoryTableSeeder::class,
            AttPriorityTableSeeder::class,
            AttStatusTableSeeder::class,
            AttTagTableSeeder::class,
            AttTypeTableSeeder::class,
            AttEfficacyTableSeeder::class,
            AttCategoryCompTableSeeder::class,

            UnitAgeTableSeeder::class,
            UnitAreaTableSeeder::class,
            UnitCapacityTableSeeder::class,
            UnitQuantityTableSeeder::class,
            UnitTemperatureTableSeeder::class,
            UnitWeightTableSeeder::class,

            SiteSettingTableSeeder::class,
            SiteWaterSourceTableSeeder::class,
            SiteWeatherTableSeeder::class,
            SiteTableSeeder::class,

            ModuleActivityTableSeeder::class,
            ModuleSystemTableSeeder::class,
            ModuleTableSeeder::class,

            PlotCodeTableSeeder::class,
            PlotStageTableSeeder::class,
            PlotPlantTableSeeder::class,
            PlotVarietyTableSeeder::class,
            PlotTableSeeder::class,

            SalesChannelTableSeeder::class,
            SalesDeliveryTableSeeder::class,
            SalesMarketTableSeeder::class,
            SalesCustomerTableSeeder::class,
            SalesLabelTableSeeder::class,

            ProductGradeTableSeeder::class,

            PurchaseBrandTableSeeder::class,
            PurchaseCompanyTableSeeder::class,
            PurchaseContactTableSeeder::class,
            PurchaseEquipmentTableSeeder::class,
            PurchaseSubstanceTableSeeder::class,
        ]);
    }
}
