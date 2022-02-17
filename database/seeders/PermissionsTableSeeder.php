<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_create',
            ],
            [
                'id'    => 3,
                'title' => 'permission_edit',
            ],
            [
                'id'    => 4,
                'title' => 'permission_show',
            ],
            [
                'id'    => 5,
                'title' => 'permission_delete',
            ],
            [
                'id'    => 6,
                'title' => 'permission_access',
            ],
            [
                'id'    => 7,
                'title' => 'role_create',
            ],
            [
                'id'    => 8,
                'title' => 'role_edit',
            ],
            [
                'id'    => 9,
                'title' => 'role_show',
            ],
            [
                'id'    => 10,
                'title' => 'role_delete',
            ],
            [
                'id'    => 11,
                'title' => 'role_access',
            ],
            [
                'id'    => 12,
                'title' => 'user_create',
            ],
            [
                'id'    => 13,
                'title' => 'user_edit',
            ],
            [
                'id'    => 14,
                'title' => 'user_show',
            ],
            [
                'id'    => 15,
                'title' => 'user_delete',
            ],
            [
                'id'    => 16,
                'title' => 'user_access',
            ],
            [
                'id'    => 17,
                'title' => 'user_alert_create',
            ],
            [
                'id'    => 18,
                'title' => 'user_alert_edit',
            ],
            [
                'id'    => 19,
                'title' => 'user_alert_show',
            ],
            [
                'id'    => 20,
                'title' => 'user_alert_delete',
            ],
            [
                'id'    => 21,
                'title' => 'user_alert_access',
            ],
            [
                'id'    => 22,
                'title' => 'site_management_access',
            ],
            [
                'id'    => 23,
                'title' => 'module_management_access',
            ],
            [
                'id'    => 24,
                'title' => 'site_setting_create',
            ],
            [
                'id'    => 25,
                'title' => 'site_setting_edit',
            ],
            [
                'id'    => 26,
                'title' => 'site_setting_show',
            ],
            [
                'id'    => 27,
                'title' => 'site_setting_delete',
            ],
            [
                'id'    => 28,
                'title' => 'site_setting_access',
            ],
            [
                'id'    => 29,
                'title' => 'unit_management_access',
            ],
            [
                'id'    => 30,
                'title' => 'unit_area_create',
            ],
            [
                'id'    => 31,
                'title' => 'unit_area_edit',
            ],
            [
                'id'    => 32,
                'title' => 'unit_area_show',
            ],
            [
                'id'    => 33,
                'title' => 'unit_area_delete',
            ],
            [
                'id'    => 34,
                'title' => 'unit_area_access',
            ],
            [
                'id'    => 35,
                'title' => 'attribute_management_access',
            ],
            [
                'id'    => 36,
                'title' => 'att_tag_create',
            ],
            [
                'id'    => 37,
                'title' => 'att_tag_edit',
            ],
            [
                'id'    => 38,
                'title' => 'att_tag_show',
            ],
            [
                'id'    => 39,
                'title' => 'att_tag_delete',
            ],
            [
                'id'    => 40,
                'title' => 'att_tag_access',
            ],
            [
                'id'    => 41,
                'title' => 'site_create',
            ],
            [
                'id'    => 42,
                'title' => 'site_edit',
            ],
            [
                'id'    => 43,
                'title' => 'site_show',
            ],
            [
                'id'    => 44,
                'title' => 'site_delete',
            ],
            [
                'id'    => 45,
                'title' => 'site_access',
            ],
            [
                'id'    => 46,
                'title' => 'cashflow_management_access',
            ],
            [
                'id'    => 47,
                'title' => 'employee_management_access',
            ],
            [
                'id'    => 48,
                'title' => 'employee_create',
            ],
            [
                'id'    => 49,
                'title' => 'employee_edit',
            ],
            [
                'id'    => 50,
                'title' => 'employee_show',
            ],
            [
                'id'    => 51,
                'title' => 'employee_delete',
            ],
            [
                'id'    => 52,
                'title' => 'employee_access',
            ],
            [
                'id'    => 53,
                'title' => 'employee_position_create',
            ],
            [
                'id'    => 54,
                'title' => 'employee_position_edit',
            ],
            [
                'id'    => 55,
                'title' => 'employee_position_show',
            ],
            [
                'id'    => 56,
                'title' => 'employee_position_delete',
            ],
            [
                'id'    => 57,
                'title' => 'employee_position_access',
            ],
            [
                'id'    => 58,
                'title' => 'module_system_create',
            ],
            [
                'id'    => 59,
                'title' => 'module_system_edit',
            ],
            [
                'id'    => 60,
                'title' => 'module_system_show',
            ],
            [
                'id'    => 61,
                'title' => 'module_system_delete',
            ],
            [
                'id'    => 62,
                'title' => 'module_system_access',
            ],
            [
                'id'    => 63,
                'title' => 'module_activity_create',
            ],
            [
                'id'    => 64,
                'title' => 'module_activity_edit',
            ],
            [
                'id'    => 65,
                'title' => 'module_activity_show',
            ],
            [
                'id'    => 66,
                'title' => 'module_activity_delete',
            ],
            [
                'id'    => 67,
                'title' => 'module_activity_access',
            ],
            [
                'id'    => 68,
                'title' => 'unit_capacity_create',
            ],
            [
                'id'    => 69,
                'title' => 'unit_capacity_edit',
            ],
            [
                'id'    => 70,
                'title' => 'unit_capacity_show',
            ],
            [
                'id'    => 71,
                'title' => 'unit_capacity_delete',
            ],
            [
                'id'    => 72,
                'title' => 'unit_capacity_access',
            ],
            [
                'id'    => 73,
                'title' => 'module_create',
            ],
            [
                'id'    => 74,
                'title' => 'module_edit',
            ],
            [
                'id'    => 75,
                'title' => 'module_show',
            ],
            [
                'id'    => 76,
                'title' => 'module_delete',
            ],
            [
                'id'    => 77,
                'title' => 'module_access',
            ],
            [
                'id'    => 78,
                'title' => 'purchase_management_access',
            ],
            [
                'id'    => 79,
                'title' => 'att_category_create',
            ],
            [
                'id'    => 80,
                'title' => 'att_category_edit',
            ],
            [
                'id'    => 81,
                'title' => 'att_category_show',
            ],
            [
                'id'    => 82,
                'title' => 'att_category_delete',
            ],
            [
                'id'    => 83,
                'title' => 'att_category_access',
            ],
            [
                'id'    => 84,
                'title' => 'unit_quantity_create',
            ],
            [
                'id'    => 85,
                'title' => 'unit_quantity_edit',
            ],
            [
                'id'    => 86,
                'title' => 'unit_quantity_show',
            ],
            [
                'id'    => 87,
                'title' => 'unit_quantity_delete',
            ],
            [
                'id'    => 88,
                'title' => 'unit_quantity_access',
            ],
            [
                'id'    => 89,
                'title' => 'product_grade_create',
            ],
            [
                'id'    => 90,
                'title' => 'product_grade_edit',
            ],
            [
                'id'    => 91,
                'title' => 'product_grade_show',
            ],
            [
                'id'    => 92,
                'title' => 'product_grade_delete',
            ],
            [
                'id'    => 93,
                'title' => 'product_grade_access',
            ],
            [
                'id'    => 94,
                'title' => 'att_status_create',
            ],
            [
                'id'    => 95,
                'title' => 'att_status_edit',
            ],
            [
                'id'    => 96,
                'title' => 'att_status_show',
            ],
            [
                'id'    => 97,
                'title' => 'att_status_delete',
            ],
            [
                'id'    => 98,
                'title' => 'att_status_access',
            ],
            [
                'id'    => 99,
                'title' => 'harvest_create',
            ],
            [
                'id'    => 100,
                'title' => 'harvest_edit',
            ],
            [
                'id'    => 101,
                'title' => 'harvest_show',
            ],
            [
                'id'    => 102,
                'title' => 'harvest_delete',
            ],
            [
                'id'    => 103,
                'title' => 'harvest_access',
            ],
            [
                'id'    => 104,
                'title' => 'unit_weight_create',
            ],
            [
                'id'    => 105,
                'title' => 'unit_weight_edit',
            ],
            [
                'id'    => 106,
                'title' => 'unit_weight_show',
            ],
            [
                'id'    => 107,
                'title' => 'unit_weight_delete',
            ],
            [
                'id'    => 108,
                'title' => 'unit_weight_access',
            ],
            [
                'id'    => 109,
                'title' => 'packing_create',
            ],
            [
                'id'    => 110,
                'title' => 'packing_edit',
            ],
            [
                'id'    => 111,
                'title' => 'packing_show',
            ],
            [
                'id'    => 112,
                'title' => 'packing_delete',
            ],
            [
                'id'    => 113,
                'title' => 'packing_access',
            ],
            [
                'id'    => 114,
                'title' => 'sales_management_access',
            ],
            [
                'id'    => 115,
                'title' => 'employee_status_create',
            ],
            [
                'id'    => 116,
                'title' => 'employee_status_edit',
            ],
            [
                'id'    => 117,
                'title' => 'employee_status_show',
            ],
            [
                'id'    => 118,
                'title' => 'employee_status_delete',
            ],
            [
                'id'    => 119,
                'title' => 'employee_status_access',
            ],
            [
                'id'    => 120,
                'title' => 'att_priority_create',
            ],
            [
                'id'    => 121,
                'title' => 'att_priority_edit',
            ],
            [
                'id'    => 122,
                'title' => 'att_priority_show',
            ],
            [
                'id'    => 123,
                'title' => 'att_priority_delete',
            ],
            [
                'id'    => 124,
                'title' => 'att_priority_access',
            ],
            [
                'id'    => 125,
                'title' => 'nutrient_control_create',
            ],
            [
                'id'    => 126,
                'title' => 'nutrient_control_edit',
            ],
            [
                'id'    => 127,
                'title' => 'nutrient_control_show',
            ],
            [
                'id'    => 128,
                'title' => 'nutrient_control_delete',
            ],
            [
                'id'    => 129,
                'title' => 'nutrient_control_access',
            ],
            [
                'id'    => 130,
                'title' => 'distribution_create',
            ],
            [
                'id'    => 131,
                'title' => 'distribution_edit',
            ],
            [
                'id'    => 132,
                'title' => 'distribution_show',
            ],
            [
                'id'    => 133,
                'title' => 'distribution_delete',
            ],
            [
                'id'    => 134,
                'title' => 'distribution_access',
            ],
            [
                'id'    => 135,
                'title' => 'unit_temperature_create',
            ],
            [
                'id'    => 136,
                'title' => 'unit_temperature_edit',
            ],
            [
                'id'    => 137,
                'title' => 'unit_temperature_show',
            ],
            [
                'id'    => 138,
                'title' => 'unit_temperature_delete',
            ],
            [
                'id'    => 139,
                'title' => 'unit_temperature_access',
            ],
            [
                'id'    => 140,
                'title' => 'att_type_create',
            ],
            [
                'id'    => 141,
                'title' => 'att_type_edit',
            ],
            [
                'id'    => 142,
                'title' => 'att_type_show',
            ],
            [
                'id'    => 143,
                'title' => 'att_type_delete',
            ],
            [
                'id'    => 144,
                'title' => 'att_type_access',
            ],
            [
                'id'    => 145,
                'title' => 'business_setting_create',
            ],
            [
                'id'    => 146,
                'title' => 'business_setting_edit',
            ],
            [
                'id'    => 147,
                'title' => 'business_setting_show',
            ],
            [
                'id'    => 148,
                'title' => 'business_setting_delete',
            ],
            [
                'id'    => 149,
                'title' => 'business_setting_access',
            ],
            [
                'id'    => 150,
                'title' => 'site_inspection_create',
            ],
            [
                'id'    => 151,
                'title' => 'site_inspection_edit',
            ],
            [
                'id'    => 152,
                'title' => 'site_inspection_show',
            ],
            [
                'id'    => 153,
                'title' => 'site_inspection_delete',
            ],
            [
                'id'    => 154,
                'title' => 'site_inspection_access',
            ],
            [
                'id'    => 155,
                'title' => 'plant_assessment_create',
            ],
            [
                'id'    => 156,
                'title' => 'plant_assessment_edit',
            ],
            [
                'id'    => 157,
                'title' => 'plant_assessment_show',
            ],
            [
                'id'    => 158,
                'title' => 'plant_assessment_delete',
            ],
            [
                'id'    => 159,
                'title' => 'plant_assessment_access',
            ],
            [
                'id'    => 160,
                'title' => 'module_observation_create',
            ],
            [
                'id'    => 161,
                'title' => 'module_observation_edit',
            ],
            [
                'id'    => 162,
                'title' => 'module_observation_show',
            ],
            [
                'id'    => 163,
                'title' => 'module_observation_delete',
            ],
            [
                'id'    => 164,
                'title' => 'module_observation_access',
            ],
            [
                'id'    => 165,
                'title' => 'care_center_access',
            ],
            [
                'id'    => 166,
                'title' => 'module_component_create',
            ],
            [
                'id'    => 167,
                'title' => 'module_component_edit',
            ],
            [
                'id'    => 168,
                'title' => 'module_component_show',
            ],
            [
                'id'    => 169,
                'title' => 'module_component_delete',
            ],
            [
                'id'    => 170,
                'title' => 'module_component_access',
            ],
            [
                'id'    => 171,
                'title' => 'att_category_comp_create',
            ],
            [
                'id'    => 172,
                'title' => 'att_category_comp_edit',
            ],
            [
                'id'    => 173,
                'title' => 'att_category_comp_show',
            ],
            [
                'id'    => 174,
                'title' => 'att_category_comp_delete',
            ],
            [
                'id'    => 175,
                'title' => 'att_category_comp_access',
            ],
            [
                'id'    => 176,
                'title' => 'unit_age_create',
            ],
            [
                'id'    => 177,
                'title' => 'unit_age_edit',
            ],
            [
                'id'    => 178,
                'title' => 'unit_age_show',
            ],
            [
                'id'    => 179,
                'title' => 'unit_age_delete',
            ],
            [
                'id'    => 180,
                'title' => 'unit_age_access',
            ],
            [
                'id'    => 181,
                'title' => 'att_efficacy_create',
            ],
            [
                'id'    => 182,
                'title' => 'att_efficacy_edit',
            ],
            [
                'id'    => 183,
                'title' => 'att_efficacy_show',
            ],
            [
                'id'    => 184,
                'title' => 'att_efficacy_delete',
            ],
            [
                'id'    => 185,
                'title' => 'att_efficacy_access',
            ],
            [
                'id'    => 186,
                'title' => 'sales_channel_create',
            ],
            [
                'id'    => 187,
                'title' => 'sales_channel_edit',
            ],
            [
                'id'    => 188,
                'title' => 'sales_channel_show',
            ],
            [
                'id'    => 189,
                'title' => 'sales_channel_delete',
            ],
            [
                'id'    => 190,
                'title' => 'sales_channel_access',
            ],
            [
                'id'    => 191,
                'title' => 'sales_market_create',
            ],
            [
                'id'    => 192,
                'title' => 'sales_market_edit',
            ],
            [
                'id'    => 193,
                'title' => 'sales_market_show',
            ],
            [
                'id'    => 194,
                'title' => 'sales_market_delete',
            ],
            [
                'id'    => 195,
                'title' => 'sales_market_access',
            ],
            [
                'id'    => 196,
                'title' => 'sales_label_create',
            ],
            [
                'id'    => 197,
                'title' => 'sales_label_edit',
            ],
            [
                'id'    => 198,
                'title' => 'sales_label_show',
            ],
            [
                'id'    => 199,
                'title' => 'sales_label_delete',
            ],
            [
                'id'    => 200,
                'title' => 'sales_label_access',
            ],
            [
                'id'    => 201,
                'title' => 'sales_delivery_create',
            ],
            [
                'id'    => 202,
                'title' => 'sales_delivery_edit',
            ],
            [
                'id'    => 203,
                'title' => 'sales_delivery_show',
            ],
            [
                'id'    => 204,
                'title' => 'sales_delivery_delete',
            ],
            [
                'id'    => 205,
                'title' => 'sales_delivery_access',
            ],
            [
                'id'    => 206,
                'title' => 'sales_customer_create',
            ],
            [
                'id'    => 207,
                'title' => 'sales_customer_edit',
            ],
            [
                'id'    => 208,
                'title' => 'sales_customer_show',
            ],
            [
                'id'    => 209,
                'title' => 'sales_customer_delete',
            ],
            [
                'id'    => 210,
                'title' => 'sales_customer_access',
            ],
            [
                'id'    => 211,
                'title' => 'purchase_brand_create',
            ],
            [
                'id'    => 212,
                'title' => 'purchase_brand_edit',
            ],
            [
                'id'    => 213,
                'title' => 'purchase_brand_show',
            ],
            [
                'id'    => 214,
                'title' => 'purchase_brand_delete',
            ],
            [
                'id'    => 215,
                'title' => 'purchase_brand_access',
            ],
            [
                'id'    => 216,
                'title' => 'purchase_company_create',
            ],
            [
                'id'    => 217,
                'title' => 'purchase_company_edit',
            ],
            [
                'id'    => 218,
                'title' => 'purchase_company_show',
            ],
            [
                'id'    => 219,
                'title' => 'purchase_company_delete',
            ],
            [
                'id'    => 220,
                'title' => 'purchase_company_access',
            ],
            [
                'id'    => 221,
                'title' => 'purchase_contact_create',
            ],
            [
                'id'    => 222,
                'title' => 'purchase_contact_edit',
            ],
            [
                'id'    => 223,
                'title' => 'purchase_contact_show',
            ],
            [
                'id'    => 224,
                'title' => 'purchase_contact_delete',
            ],
            [
                'id'    => 225,
                'title' => 'purchase_contact_access',
            ],
            [
                'id'    => 226,
                'title' => 'purchase_equipment_create',
            ],
            [
                'id'    => 227,
                'title' => 'purchase_equipment_edit',
            ],
            [
                'id'    => 228,
                'title' => 'purchase_equipment_show',
            ],
            [
                'id'    => 229,
                'title' => 'purchase_equipment_delete',
            ],
            [
                'id'    => 230,
                'title' => 'purchase_equipment_access',
            ],
            [
                'id'    => 231,
                'title' => 'purchase_substance_create',
            ],
            [
                'id'    => 232,
                'title' => 'purchase_substance_edit',
            ],
            [
                'id'    => 233,
                'title' => 'purchase_substance_show',
            ],
            [
                'id'    => 234,
                'title' => 'purchase_substance_delete',
            ],
            [
                'id'    => 235,
                'title' => 'purchase_substance_access',
            ],
            [
                'id'    => 236,
                'title' => 'care_pre_order_create',
            ],
            [
                'id'    => 237,
                'title' => 'care_pre_order_edit',
            ],
            [
                'id'    => 238,
                'title' => 'care_pre_order_show',
            ],
            [
                'id'    => 239,
                'title' => 'care_pre_order_delete',
            ],
            [
                'id'    => 240,
                'title' => 'care_pre_order_access',
            ],
            [
                'id'    => 241,
                'title' => 'site_water_source_create',
            ],
            [
                'id'    => 242,
                'title' => 'site_water_source_edit',
            ],
            [
                'id'    => 243,
                'title' => 'site_water_source_show',
            ],
            [
                'id'    => 244,
                'title' => 'site_water_source_delete',
            ],
            [
                'id'    => 245,
                'title' => 'site_water_source_access',
            ],
            [
                'id'    => 246,
                'title' => 'site_weather_create',
            ],
            [
                'id'    => 247,
                'title' => 'site_weather_edit',
            ],
            [
                'id'    => 248,
                'title' => 'site_weather_show',
            ],
            [
                'id'    => 249,
                'title' => 'site_weather_delete',
            ],
            [
                'id'    => 250,
                'title' => 'site_weather_access',
            ],
            [
                'id'    => 251,
                'title' => 'cashflow_expense_category_create',
            ],
            [
                'id'    => 252,
                'title' => 'cashflow_expense_category_edit',
            ],
            [
                'id'    => 253,
                'title' => 'cashflow_expense_category_show',
            ],
            [
                'id'    => 254,
                'title' => 'cashflow_expense_category_delete',
            ],
            [
                'id'    => 255,
                'title' => 'cashflow_expense_category_access',
            ],
            [
                'id'    => 256,
                'title' => 'cashflow_income_create',
            ],
            [
                'id'    => 257,
                'title' => 'cashflow_income_edit',
            ],
            [
                'id'    => 258,
                'title' => 'cashflow_income_show',
            ],
            [
                'id'    => 259,
                'title' => 'cashflow_income_delete',
            ],
            [
                'id'    => 260,
                'title' => 'cashflow_income_access',
            ],
            [
                'id'    => 261,
                'title' => 'cashflow_expense_create',
            ],
            [
                'id'    => 262,
                'title' => 'cashflow_expense_edit',
            ],
            [
                'id'    => 263,
                'title' => 'cashflow_expense_show',
            ],
            [
                'id'    => 264,
                'title' => 'cashflow_expense_delete',
            ],
            [
                'id'    => 265,
                'title' => 'cashflow_expense_access',
            ],
            [
                'id'    => 266,
                'title' => 'cashflow_income_category_create',
            ],
            [
                'id'    => 267,
                'title' => 'cashflow_income_category_edit',
            ],
            [
                'id'    => 268,
                'title' => 'cashflow_income_category_show',
            ],
            [
                'id'    => 269,
                'title' => 'cashflow_income_category_delete',
            ],
            [
                'id'    => 270,
                'title' => 'cashflow_income_category_access',
            ],
            [
                'id'    => 271,
                'title' => 'employee_job_desc_create',
            ],
            [
                'id'    => 272,
                'title' => 'employee_job_desc_edit',
            ],
            [
                'id'    => 273,
                'title' => 'employee_job_desc_show',
            ],
            [
                'id'    => 274,
                'title' => 'employee_job_desc_delete',
            ],
            [
                'id'    => 275,
                'title' => 'employee_job_desc_access',
            ],
            [
                'id'    => 276,
                'title' => 'administrator_access',
            ],
            [
                'id'    => 277,
                'title' => 'admin_plan_create',
            ],
            [
                'id'    => 278,
                'title' => 'admin_plan_edit',
            ],
            [
                'id'    => 279,
                'title' => 'admin_plan_show',
            ],
            [
                'id'    => 280,
                'title' => 'admin_plan_delete',
            ],
            [
                'id'    => 281,
                'title' => 'admin_plan_access',
            ],
            [
                'id'    => 282,
                'title' => 'admin_setting_create',
            ],
            [
                'id'    => 283,
                'title' => 'admin_setting_edit',
            ],
            [
                'id'    => 284,
                'title' => 'admin_setting_show',
            ],
            [
                'id'    => 285,
                'title' => 'admin_setting_delete',
            ],
            [
                'id'    => 286,
                'title' => 'admin_setting_access',
            ],
            [
                'id'    => 287,
                'title' => 'admin_info_create',
            ],
            [
                'id'    => 288,
                'title' => 'admin_info_edit',
            ],
            [
                'id'    => 289,
                'title' => 'admin_info_show',
            ],
            [
                'id'    => 290,
                'title' => 'admin_info_delete',
            ],
            [
                'id'    => 291,
                'title' => 'admin_info_access',
            ],
            [
                'id'    => 292,
                'title' => 'admin_database_create',
            ],
            [
                'id'    => 293,
                'title' => 'admin_database_edit',
            ],
            [
                'id'    => 294,
                'title' => 'admin_database_show',
            ],
            [
                'id'    => 295,
                'title' => 'admin_database_delete',
            ],
            [
                'id'    => 296,
                'title' => 'admin_database_access',
            ],
            [
                'id'    => 297,
                'title' => 'admin_category_create',
            ],
            [
                'id'    => 298,
                'title' => 'admin_category_edit',
            ],
            [
                'id'    => 299,
                'title' => 'admin_category_show',
            ],
            [
                'id'    => 300,
                'title' => 'admin_category_delete',
            ],
            [
                'id'    => 301,
                'title' => 'admin_category_access',
            ],
            [
                'id'    => 302,
                'title' => 'admin_tag_create',
            ],
            [
                'id'    => 303,
                'title' => 'admin_tag_edit',
            ],
            [
                'id'    => 304,
                'title' => 'admin_tag_show',
            ],
            [
                'id'    => 305,
                'title' => 'admin_tag_delete',
            ],
            [
                'id'    => 306,
                'title' => 'admin_tag_access',
            ],
            [
                'id'    => 307,
                'title' => 'admin_expert_create',
            ],
            [
                'id'    => 308,
                'title' => 'admin_expert_edit',
            ],
            [
                'id'    => 309,
                'title' => 'admin_expert_show',
            ],
            [
                'id'    => 310,
                'title' => 'admin_expert_delete',
            ],
            [
                'id'    => 311,
                'title' => 'admin_expert_access',
            ],
            [
                'id'    => 312,
                'title' => 'team_create',
            ],
            [
                'id'    => 313,
                'title' => 'team_edit',
            ],
            [
                'id'    => 314,
                'title' => 'team_show',
            ],
            [
                'id'    => 315,
                'title' => 'team_delete',
            ],
            [
                'id'    => 316,
                'title' => 'team_access',
            ],
            [
                'id'    => 317,
                'title' => 'cashflow_sale_create',
            ],
            [
                'id'    => 318,
                'title' => 'cashflow_sale_edit',
            ],
            [
                'id'    => 319,
                'title' => 'cashflow_sale_show',
            ],
            [
                'id'    => 320,
                'title' => 'cashflow_sale_delete',
            ],
            [
                'id'    => 321,
                'title' => 'cashflow_sale_access',
            ],
            [
                'id'    => 322,
                'title' => 'cashflow_purchase_create',
            ],
            [
                'id'    => 323,
                'title' => 'cashflow_purchase_edit',
            ],
            [
                'id'    => 324,
                'title' => 'cashflow_purchase_show',
            ],
            [
                'id'    => 325,
                'title' => 'cashflow_purchase_delete',
            ],
            [
                'id'    => 326,
                'title' => 'cashflow_purchase_access',
            ],
            [
                'id'    => 327,
                'title' => 'post_production_access',
            ],
            [
                'id'    => 328,
                'title' => 'field_management_access',
            ],
            [
                'id'    => 329,
                'title' => 'plot_create',
            ],
            [
                'id'    => 330,
                'title' => 'plot_edit',
            ],
            [
                'id'    => 331,
                'title' => 'plot_show',
            ],
            [
                'id'    => 332,
                'title' => 'plot_delete',
            ],
            [
                'id'    => 333,
                'title' => 'plot_access',
            ],
            [
                'id'    => 334,
                'title' => 'plot_management_access',
            ],
            [
                'id'    => 335,
                'title' => 'plot_plant_create',
            ],
            [
                'id'    => 336,
                'title' => 'plot_plant_edit',
            ],
            [
                'id'    => 337,
                'title' => 'plot_plant_show',
            ],
            [
                'id'    => 338,
                'title' => 'plot_plant_delete',
            ],
            [
                'id'    => 339,
                'title' => 'plot_plant_access',
            ],
            [
                'id'    => 340,
                'title' => 'plot_stage_create',
            ],
            [
                'id'    => 341,
                'title' => 'plot_stage_edit',
            ],
            [
                'id'    => 342,
                'title' => 'plot_stage_show',
            ],
            [
                'id'    => 343,
                'title' => 'plot_stage_delete',
            ],
            [
                'id'    => 344,
                'title' => 'plot_stage_access',
            ],
            [
                'id'    => 345,
                'title' => 'plot_variety_create',
            ],
            [
                'id'    => 346,
                'title' => 'plot_variety_edit',
            ],
            [
                'id'    => 347,
                'title' => 'plot_variety_show',
            ],
            [
                'id'    => 348,
                'title' => 'plot_variety_delete',
            ],
            [
                'id'    => 349,
                'title' => 'plot_variety_access',
            ],
            [
                'id'    => 350,
                'title' => 'plot_code_create',
            ],
            [
                'id'    => 351,
                'title' => 'plot_code_edit',
            ],
            [
                'id'    => 352,
                'title' => 'plot_code_show',
            ],
            [
                'id'    => 353,
                'title' => 'plot_code_delete',
            ],
            [
                'id'    => 354,
                'title' => 'plot_code_access',
            ],
            [
                'id'    => 355,
                'title' => 'care_harvest_create',
            ],
            [
                'id'    => 356,
                'title' => 'care_harvest_edit',
            ],
            [
                'id'    => 357,
                'title' => 'care_harvest_show',
            ],
            [
                'id'    => 358,
                'title' => 'care_harvest_delete',
            ],
            [
                'id'    => 359,
                'title' => 'care_harvest_access',
            ],
            [
                'id'    => 360,
                'title' => 'care_packing_create',
            ],
            [
                'id'    => 361,
                'title' => 'care_packing_edit',
            ],
            [
                'id'    => 362,
                'title' => 'care_packing_show',
            ],
            [
                'id'    => 363,
                'title' => 'care_packing_delete',
            ],
            [
                'id'    => 364,
                'title' => 'care_packing_access',
            ],
            [
                'id'    => 365,
                'title' => 'care_distribution_create',
            ],
            [
                'id'    => 366,
                'title' => 'care_distribution_edit',
            ],
            [
                'id'    => 367,
                'title' => 'care_distribution_show',
            ],
            [
                'id'    => 368,
                'title' => 'care_distribution_delete',
            ],
            [
                'id'    => 369,
                'title' => 'care_distribution_access',
            ],
            [
                'id'    => 370,
                'title' => 'care_module_create',
            ],
            [
                'id'    => 371,
                'title' => 'care_module_edit',
            ],
            [
                'id'    => 372,
                'title' => 'care_module_show',
            ],
            [
                'id'    => 373,
                'title' => 'care_module_delete',
            ],
            [
                'id'    => 374,
                'title' => 'care_module_access',
            ],
            [
                'id'    => 375,
                'title' => 'care_site_create',
            ],
            [
                'id'    => 376,
                'title' => 'care_site_edit',
            ],
            [
                'id'    => 377,
                'title' => 'care_site_show',
            ],
            [
                'id'    => 378,
                'title' => 'care_site_delete',
            ],
            [
                'id'    => 379,
                'title' => 'care_site_access',
            ],
            [
                'id'    => 380,
                'title' => 'care_plant_assessment_create',
            ],
            [
                'id'    => 381,
                'title' => 'care_plant_assessment_edit',
            ],
            [
                'id'    => 382,
                'title' => 'care_plant_assessment_show',
            ],
            [
                'id'    => 383,
                'title' => 'care_plant_assessment_delete',
            ],
            [
                'id'    => 384,
                'title' => 'care_plant_assessment_access',
            ],
            [
                'id'    => 385,
                'title' => 'care_nutrient_control_create',
            ],
            [
                'id'    => 386,
                'title' => 'care_nutrient_control_edit',
            ],
            [
                'id'    => 387,
                'title' => 'care_nutrient_control_show',
            ],
            [
                'id'    => 388,
                'title' => 'care_nutrient_control_delete',
            ],
            [
                'id'    => 389,
                'title' => 'care_nutrient_control_access',
            ],
            [
                'id'    => 390,
                'title' => 'care_sale_create',
            ],
            [
                'id'    => 391,
                'title' => 'care_sale_edit',
            ],
            [
                'id'    => 392,
                'title' => 'care_sale_show',
            ],
            [
                'id'    => 393,
                'title' => 'care_sale_delete',
            ],
            [
                'id'    => 394,
                'title' => 'care_sale_access',
            ],
            [
                'id'    => 395,
                'title' => 'care_purchase_create',
            ],
            [
                'id'    => 396,
                'title' => 'care_purchase_edit',
            ],
            [
                'id'    => 397,
                'title' => 'care_purchase_show',
            ],
            [
                'id'    => 398,
                'title' => 'care_purchase_delete',
            ],
            [
                'id'    => 399,
                'title' => 'care_purchase_access',
            ],
            [
                'id'    => 400,
                'title' => 'care_list_page_create',
            ],
            [
                'id'    => 401,
                'title' => 'care_list_page_edit',
            ],
            [
                'id'    => 402,
                'title' => 'care_list_page_show',
            ],
            [
                'id'    => 403,
                'title' => 'care_list_page_delete',
            ],
            [
                'id'    => 404,
                'title' => 'care_list_page_access',
            ],
            [
                'id'    => 405,
                'title' => 'employee_attendance_create',
            ],
            [
                'id'    => 406,
                'title' => 'employee_attendance_edit',
            ],
            [
                'id'    => 407,
                'title' => 'employee_attendance_show',
            ],
            [
                'id'    => 408,
                'title' => 'employee_attendance_delete',
            ],
            [
                'id'    => 409,
                'title' => 'employee_attendance_access',
            ],
            [
                'id'    => 410,
                'title' => 'employee_leave_create',
            ],
            [
                'id'    => 411,
                'title' => 'employee_leave_edit',
            ],
            [
                'id'    => 412,
                'title' => 'employee_leave_show',
            ],
            [
                'id'    => 413,
                'title' => 'employee_leave_delete',
            ],
            [
                'id'    => 414,
                'title' => 'employee_leave_access',
            ],
            [
                'id'    => 415,
                'title' => 'emp_leave_type_create',
            ],
            [
                'id'    => 416,
                'title' => 'emp_leave_type_edit',
            ],
            [
                'id'    => 417,
                'title' => 'emp_leave_type_show',
            ],
            [
                'id'    => 418,
                'title' => 'emp_leave_type_delete',
            ],
            [
                'id'    => 419,
                'title' => 'emp_leave_type_access',
            ],
            [
                'id'    => 420,
                'title' => 'task_create',
            ],
            [
                'id'    => 421,
                'title' => 'task_edit',
            ],
            [
                'id'    => 422,
                'title' => 'task_show',
            ],
            [
                'id'    => 423,
                'title' => 'task_delete',
            ],
            [
                'id'    => 424,
                'title' => 'task_access',
            ],
            [
                'id'    => 425,
                'title' => 'faq_management_access',
            ],
            [
                'id'    => 426,
                'title' => 'faq_category_create',
            ],
            [
                'id'    => 427,
                'title' => 'faq_category_edit',
            ],
            [
                'id'    => 428,
                'title' => 'faq_category_show',
            ],
            [
                'id'    => 429,
                'title' => 'faq_category_delete',
            ],
            [
                'id'    => 430,
                'title' => 'faq_category_access',
            ],
            [
                'id'    => 431,
                'title' => 'faq_question_create',
            ],
            [
                'id'    => 432,
                'title' => 'faq_question_edit',
            ],
            [
                'id'    => 433,
                'title' => 'faq_question_show',
            ],
            [
                'id'    => 434,
                'title' => 'faq_question_delete',
            ],
            [
                'id'    => 435,
                'title' => 'faq_question_access',
            ],
            [
                'id'    => 436,
                'title' => 'audit_log_show',
            ],
            [
                'id'    => 437,
                'title' => 'audit_log_access',
            ],
            [
                'id'    => 438,
                'title' => 'sales_payment_create',
            ],
            [
                'id'    => 439,
                'title' => 'sales_payment_edit',
            ],
            [
                'id'    => 440,
                'title' => 'sales_payment_show',
            ],
            [
                'id'    => 441,
                'title' => 'sales_payment_delete',
            ],
            [
                'id'    => 442,
                'title' => 'sales_payment_access',
            ],
            [
                'id'    => 443,
                'title' => 'profile_password_edit',
            ],
        ];

        Permission::insert($permissions);
    }
}
