<?php

namespace App\Http\Controllers\Admin;

use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class HomeController
{
    public function index()
    {
        $settings1 = [
            'chart_title'           => 'Total Users',
            'chart_type'            => 'number_block',
            'report_type'           => 'group_by_date',
            'model'                 => 'App\Models\User',
            'group_by_field'        => 'email_verified_at',
            'group_by_period'       => 'day',
            'aggregate_function'    => 'count',
            'filter_field'          => 'created_at',
            'group_by_field_format' => 'd.m.Y H:i:s',
            'column_class'          => 'col-md-3',
            'entries_number'        => '5',
            'translation_key'       => 'user',
        ];

        $settings1['total_number'] = 0;
        if (class_exists($settings1['model'])) {
            $settings1['total_number'] = $settings1['model']::when(isset($settings1['filter_field']), function ($query) use ($settings1) {
                if (isset($settings1['filter_days'])) {
                    return $query->where($settings1['filter_field'], '>=',
                now()->subDays($settings1['filter_days'])->format('Y-m-d'));
                }
                if (isset($settings1['filter_period'])) {
                    switch ($settings1['filter_period']) {
                case 'week': $start = date('Y-m-d', strtotime('last Monday')); break;
                case 'month': $start = date('Y-m') . '-01'; break;
                case 'year': $start = date('Y') . '-01-01'; break;
            }
                    if (isset($start)) {
                        return $query->where($settings1['filter_field'], '>=', $start);
                    }
                }
            })
                ->{$settings1['aggregate_function'] ?? 'count'}($settings1['aggregate_field'] ?? '*');
        }

        $settings2 = [
            'chart_title'           => 'This Week',
            'chart_type'            => 'number_block',
            'report_type'           => 'group_by_date',
            'model'                 => 'App\Models\User',
            'group_by_field'        => 'email_verified_at',
            'group_by_period'       => 'day',
            'aggregate_function'    => 'count',
            'filter_field'          => 'created_at',
            'filter_period'         => 'week',
            'group_by_field_format' => 'd.m.Y H:i:s',
            'column_class'          => 'col-md-3',
            'entries_number'        => '5',
            'translation_key'       => 'user',
        ];

        $settings2['total_number'] = 0;
        if (class_exists($settings2['model'])) {
            $settings2['total_number'] = $settings2['model']::when(isset($settings2['filter_field']), function ($query) use ($settings2) {
                if (isset($settings2['filter_days'])) {
                    return $query->where($settings2['filter_field'], '>=',
                now()->subDays($settings2['filter_days'])->format('Y-m-d'));
                }
                if (isset($settings2['filter_period'])) {
                    switch ($settings2['filter_period']) {
                case 'week': $start = date('Y-m-d', strtotime('last Monday')); break;
                case 'month': $start = date('Y-m') . '-01'; break;
                case 'year': $start = date('Y') . '-01-01'; break;
            }
                    if (isset($start)) {
                        return $query->where($settings2['filter_field'], '>=', $start);
                    }
                }
            })
                ->{$settings2['aggregate_function'] ?? 'count'}($settings2['aggregate_field'] ?? '*');
        }

        $settings3 = [
            'chart_title'           => 'This Month',
            'chart_type'            => 'number_block',
            'report_type'           => 'group_by_date',
            'model'                 => 'App\Models\User',
            'group_by_field'        => 'email_verified_at',
            'group_by_period'       => 'day',
            'aggregate_function'    => 'count',
            'filter_field'          => 'created_at',
            'filter_period'         => 'month',
            'group_by_field_format' => 'd.m.Y H:i:s',
            'column_class'          => 'col-md-3',
            'entries_number'        => '5',
            'translation_key'       => 'user',
        ];

        $settings3['total_number'] = 0;
        if (class_exists($settings3['model'])) {
            $settings3['total_number'] = $settings3['model']::when(isset($settings3['filter_field']), function ($query) use ($settings3) {
                if (isset($settings3['filter_days'])) {
                    return $query->where($settings3['filter_field'], '>=',
                now()->subDays($settings3['filter_days'])->format('Y-m-d'));
                }
                if (isset($settings3['filter_period'])) {
                    switch ($settings3['filter_period']) {
                case 'week': $start = date('Y-m-d', strtotime('last Monday')); break;
                case 'month': $start = date('Y-m') . '-01'; break;
                case 'year': $start = date('Y') . '-01-01'; break;
            }
                    if (isset($start)) {
                        return $query->where($settings3['filter_field'], '>=', $start);
                    }
                }
            })
                ->{$settings3['aggregate_function'] ?? 'count'}($settings3['aggregate_field'] ?? '*');
        }

        $settings4 = [
            'chart_title'           => 'This Year',
            'chart_type'            => 'number_block',
            'report_type'           => 'group_by_date',
            'model'                 => 'App\Models\User',
            'group_by_field'        => 'email_verified_at',
            'group_by_period'       => 'day',
            'aggregate_function'    => 'count',
            'filter_field'          => 'created_at',
            'filter_period'         => 'year',
            'group_by_field_format' => 'd.m.Y H:i:s',
            'column_class'          => 'col-md-3',
            'entries_number'        => '5',
            'translation_key'       => 'user',
        ];

        $settings4['total_number'] = 0;
        if (class_exists($settings4['model'])) {
            $settings4['total_number'] = $settings4['model']::when(isset($settings4['filter_field']), function ($query) use ($settings4) {
                if (isset($settings4['filter_days'])) {
                    return $query->where($settings4['filter_field'], '>=',
                now()->subDays($settings4['filter_days'])->format('Y-m-d'));
                }
                if (isset($settings4['filter_period'])) {
                    switch ($settings4['filter_period']) {
                case 'week': $start = date('Y-m-d', strtotime('last Monday')); break;
                case 'month': $start = date('Y-m') . '-01'; break;
                case 'year': $start = date('Y') . '-01-01'; break;
            }
                    if (isset($start)) {
                        return $query->where($settings4['filter_field'], '>=', $start);
                    }
                }
            })
                ->{$settings4['aggregate_function'] ?? 'count'}($settings4['aggregate_field'] ?? '*');
        }

        $settings5 = [
            'chart_title'           => 'Total Teams',
            'chart_type'            => 'number_block',
            'report_type'           => 'group_by_date',
            'model'                 => 'App\Models\Team',
            'group_by_field'        => 'created_at',
            'group_by_period'       => 'day',
            'aggregate_function'    => 'count',
            'filter_field'          => 'created_at',
            'group_by_field_format' => 'd.m.Y H:i:s',
            'column_class'          => 'col-md-3',
            'entries_number'        => '5',
            'translation_key'       => 'team',
        ];

        $settings5['total_number'] = 0;
        if (class_exists($settings5['model'])) {
            $settings5['total_number'] = $settings5['model']::when(isset($settings5['filter_field']), function ($query) use ($settings5) {
                if (isset($settings5['filter_days'])) {
                    return $query->where($settings5['filter_field'], '>=',
                now()->subDays($settings5['filter_days'])->format('Y-m-d'));
                }
                if (isset($settings5['filter_period'])) {
                    switch ($settings5['filter_period']) {
                case 'week': $start = date('Y-m-d', strtotime('last Monday')); break;
                case 'month': $start = date('Y-m') . '-01'; break;
                case 'year': $start = date('Y') . '-01-01'; break;
            }
                    if (isset($start)) {
                        return $query->where($settings5['filter_field'], '>=', $start);
                    }
                }
            })
                ->{$settings5['aggregate_function'] ?? 'count'}($settings5['aggregate_field'] ?? '*');
        }

        $settings6 = [
            'chart_title'           => 'This Week',
            'chart_type'            => 'number_block',
            'report_type'           => 'group_by_date',
            'model'                 => 'App\Models\Team',
            'group_by_field'        => 'created_at',
            'group_by_period'       => 'day',
            'aggregate_function'    => 'count',
            'filter_field'          => 'created_at',
            'filter_period'         => 'week',
            'group_by_field_format' => 'd.m.Y H:i:s',
            'column_class'          => 'col-md-3',
            'entries_number'        => '5',
            'translation_key'       => 'team',
        ];

        $settings6['total_number'] = 0;
        if (class_exists($settings6['model'])) {
            $settings6['total_number'] = $settings6['model']::when(isset($settings6['filter_field']), function ($query) use ($settings6) {
                if (isset($settings6['filter_days'])) {
                    return $query->where($settings6['filter_field'], '>=',
                now()->subDays($settings6['filter_days'])->format('Y-m-d'));
                }
                if (isset($settings6['filter_period'])) {
                    switch ($settings6['filter_period']) {
                case 'week': $start = date('Y-m-d', strtotime('last Monday')); break;
                case 'month': $start = date('Y-m') . '-01'; break;
                case 'year': $start = date('Y') . '-01-01'; break;
            }
                    if (isset($start)) {
                        return $query->where($settings6['filter_field'], '>=', $start);
                    }
                }
            })
                ->{$settings6['aggregate_function'] ?? 'count'}($settings6['aggregate_field'] ?? '*');
        }

        $settings7 = [
            'chart_title'           => 'This Month',
            'chart_type'            => 'number_block',
            'report_type'           => 'group_by_date',
            'model'                 => 'App\Models\Team',
            'group_by_field'        => 'created_at',
            'group_by_period'       => 'day',
            'aggregate_function'    => 'count',
            'filter_field'          => 'created_at',
            'filter_period'         => 'month',
            'group_by_field_format' => 'd.m.Y H:i:s',
            'column_class'          => 'col-md-3',
            'entries_number'        => '5',
            'translation_key'       => 'team',
        ];

        $settings7['total_number'] = 0;
        if (class_exists($settings7['model'])) {
            $settings7['total_number'] = $settings7['model']::when(isset($settings7['filter_field']), function ($query) use ($settings7) {
                if (isset($settings7['filter_days'])) {
                    return $query->where($settings7['filter_field'], '>=',
                now()->subDays($settings7['filter_days'])->format('Y-m-d'));
                }
                if (isset($settings7['filter_period'])) {
                    switch ($settings7['filter_period']) {
                case 'week': $start = date('Y-m-d', strtotime('last Monday')); break;
                case 'month': $start = date('Y-m') . '-01'; break;
                case 'year': $start = date('Y') . '-01-01'; break;
            }
                    if (isset($start)) {
                        return $query->where($settings7['filter_field'], '>=', $start);
                    }
                }
            })
                ->{$settings7['aggregate_function'] ?? 'count'}($settings7['aggregate_field'] ?? '*');
        }

        $settings8 = [
            'chart_title'           => 'This Year',
            'chart_type'            => 'number_block',
            'report_type'           => 'group_by_date',
            'model'                 => 'App\Models\Team',
            'group_by_field'        => 'created_at',
            'group_by_period'       => 'day',
            'aggregate_function'    => 'count',
            'filter_field'          => 'created_at',
            'filter_period'         => 'year',
            'group_by_field_format' => 'd.m.Y H:i:s',
            'column_class'          => 'col-md-3',
            'entries_number'        => '5',
            'translation_key'       => 'team',
        ];

        $settings8['total_number'] = 0;
        if (class_exists($settings8['model'])) {
            $settings8['total_number'] = $settings8['model']::when(isset($settings8['filter_field']), function ($query) use ($settings8) {
                if (isset($settings8['filter_days'])) {
                    return $query->where($settings8['filter_field'], '>=',
                now()->subDays($settings8['filter_days'])->format('Y-m-d'));
                }
                if (isset($settings8['filter_period'])) {
                    switch ($settings8['filter_period']) {
                case 'week': $start = date('Y-m-d', strtotime('last Monday')); break;
                case 'month': $start = date('Y-m') . '-01'; break;
                case 'year': $start = date('Y') . '-01-01'; break;
            }
                    if (isset($start)) {
                        return $query->where($settings8['filter_field'], '>=', $start);
                    }
                }
            })
                ->{$settings8['aggregate_function'] ?? 'count'}($settings8['aggregate_field'] ?? '*');
        }

        $settings9 = [
            'chart_title'           => 'Sites',
            'chart_type'            => 'number_block',
            'report_type'           => 'group_by_date',
            'model'                 => 'App\Models\CareSite',
            'group_by_field'        => 'created_at',
            'group_by_period'       => 'day',
            'aggregate_function'    => 'count',
            'filter_field'          => 'created_at',
            'group_by_field_format' => 'd.m.Y H:i:s',
            'column_class'          => 'col-md-4',
            'entries_number'        => '5',
            'translation_key'       => 'careSite',
        ];

        $settings9['total_number'] = 0;
        if (class_exists($settings9['model'])) {
            $settings9['total_number'] = $settings9['model']::when(isset($settings9['filter_field']), function ($query) use ($settings9) {
                if (isset($settings9['filter_days'])) {
                    return $query->where($settings9['filter_field'], '>=',
                now()->subDays($settings9['filter_days'])->format('Y-m-d'));
                }
                if (isset($settings9['filter_period'])) {
                    switch ($settings9['filter_period']) {
                case 'week': $start = date('Y-m-d', strtotime('last Monday')); break;
                case 'month': $start = date('Y-m') . '-01'; break;
                case 'year': $start = date('Y') . '-01-01'; break;
            }
                    if (isset($start)) {
                        return $query->where($settings9['filter_field'], '>=', $start);
                    }
                }
            })
                ->{$settings9['aggregate_function'] ?? 'count'}($settings9['aggregate_field'] ?? '*');
        }

        $settings10 = [
            'chart_title'           => 'Modules',
            'chart_type'            => 'number_block',
            'report_type'           => 'group_by_date',
            'model'                 => 'App\Models\CareModule',
            'group_by_field'        => 'created_at',
            'group_by_period'       => 'day',
            'aggregate_function'    => 'count',
            'filter_field'          => 'created_at',
            'group_by_field_format' => 'd.m.Y H:i:s',
            'column_class'          => 'col-md-4',
            'entries_number'        => '5',
            'translation_key'       => 'careModule',
        ];

        $settings10['total_number'] = 0;
        if (class_exists($settings10['model'])) {
            $settings10['total_number'] = $settings10['model']::when(isset($settings10['filter_field']), function ($query) use ($settings10) {
                if (isset($settings10['filter_days'])) {
                    return $query->where($settings10['filter_field'], '>=',
                now()->subDays($settings10['filter_days'])->format('Y-m-d'));
                }
                if (isset($settings10['filter_period'])) {
                    switch ($settings10['filter_period']) {
                case 'week': $start = date('Y-m-d', strtotime('last Monday')); break;
                case 'month': $start = date('Y-m') . '-01'; break;
                case 'year': $start = date('Y') . '-01-01'; break;
            }
                    if (isset($start)) {
                        return $query->where($settings10['filter_field'], '>=', $start);
                    }
                }
            })
                ->{$settings10['aggregate_function'] ?? 'count'}($settings10['aggregate_field'] ?? '*');
        }

        $settings11 = [
            'chart_title'           => 'Plots',
            'chart_type'            => 'number_block',
            'report_type'           => 'group_by_date',
            'model'                 => 'App\Models\Plot',
            'group_by_field'        => 'created_at',
            'group_by_period'       => 'day',
            'aggregate_function'    => 'sum',
            'aggregate_field'       => 'plot_qty',
            'filter_field'          => 'created_at',
            'group_by_field_format' => 'd.m.Y H:i:s',
            'column_class'          => 'col-md-4',
            'entries_number'        => '5',
            'translation_key'       => 'plot',
        ];

        $settings11['total_number'] = 0;
        if (class_exists($settings11['model'])) {
            $settings11['total_number'] = $settings11['model']::when(isset($settings11['filter_field']), function ($query) use ($settings11) {
                if (isset($settings11['filter_days'])) {
                    return $query->where($settings11['filter_field'], '>=',
                now()->subDays($settings11['filter_days'])->format('Y-m-d'));
                }
                if (isset($settings11['filter_period'])) {
                    switch ($settings11['filter_period']) {
                case 'week': $start = date('Y-m-d', strtotime('last Monday')); break;
                case 'month': $start = date('Y-m') . '-01'; break;
                case 'year': $start = date('Y') . '-01-01'; break;
            }
                    if (isset($start)) {
                        return $query->where($settings11['filter_field'], '>=', $start);
                    }
                }
            })
                ->{$settings11['aggregate_function'] ?? 'count'}($settings11['aggregate_field'] ?? '*');
        }

        $settings12 = [
            'chart_title'           => 'Total Harvests',
            'chart_type'            => 'number_block',
            'report_type'           => 'group_by_date',
            'model'                 => 'App\Models\Harvest',
            'group_by_field'        => 'created_at',
            'group_by_period'       => 'day',
            'aggregate_function'    => 'sum',
            'aggregate_field'       => 'harvest_qty',
            'filter_field'          => 'created_at',
            'group_by_field_format' => 'd.m.Y H:i:s',
            'column_class'          => 'col-md-3',
            'entries_number'        => '5',
            'translation_key'       => 'harvest',
        ];

        $settings12['total_number'] = 0;
        if (class_exists($settings12['model'])) {
            $settings12['total_number'] = $settings12['model']::when(isset($settings12['filter_field']), function ($query) use ($settings12) {
                if (isset($settings12['filter_days'])) {
                    return $query->where($settings12['filter_field'], '>=',
                now()->subDays($settings12['filter_days'])->format('Y-m-d'));
                }
                if (isset($settings12['filter_period'])) {
                    switch ($settings12['filter_period']) {
                case 'week': $start = date('Y-m-d', strtotime('last Monday')); break;
                case 'month': $start = date('Y-m') . '-01'; break;
                case 'year': $start = date('Y') . '-01-01'; break;
            }
                    if (isset($start)) {
                        return $query->where($settings12['filter_field'], '>=', $start);
                    }
                }
            })
                ->{$settings12['aggregate_function'] ?? 'count'}($settings12['aggregate_field'] ?? '*');
        }

        $settings13 = [
            'chart_title'           => 'This Week',
            'chart_type'            => 'number_block',
            'report_type'           => 'group_by_date',
            'model'                 => 'App\Models\Harvest',
            'group_by_field'        => 'created_at',
            'group_by_period'       => 'day',
            'aggregate_function'    => 'sum',
            'aggregate_field'       => 'harvest_qty',
            'filter_field'          => 'created_at',
            'filter_period'         => 'week',
            'group_by_field_format' => 'd.m.Y H:i:s',
            'column_class'          => 'col-md-3',
            'entries_number'        => '5',
            'translation_key'       => 'harvest',
        ];

        $settings13['total_number'] = 0;
        if (class_exists($settings13['model'])) {
            $settings13['total_number'] = $settings13['model']::when(isset($settings13['filter_field']), function ($query) use ($settings13) {
                if (isset($settings13['filter_days'])) {
                    return $query->where($settings13['filter_field'], '>=',
                now()->subDays($settings13['filter_days'])->format('Y-m-d'));
                }
                if (isset($settings13['filter_period'])) {
                    switch ($settings13['filter_period']) {
                case 'week': $start = date('Y-m-d', strtotime('last Monday')); break;
                case 'month': $start = date('Y-m') . '-01'; break;
                case 'year': $start = date('Y') . '-01-01'; break;
            }
                    if (isset($start)) {
                        return $query->where($settings13['filter_field'], '>=', $start);
                    }
                }
            })
                ->{$settings13['aggregate_function'] ?? 'count'}($settings13['aggregate_field'] ?? '*');
        }

        $settings14 = [
            'chart_title'           => 'This Month',
            'chart_type'            => 'number_block',
            'report_type'           => 'group_by_date',
            'model'                 => 'App\Models\Harvest',
            'group_by_field'        => 'created_at',
            'group_by_period'       => 'day',
            'aggregate_function'    => 'sum',
            'aggregate_field'       => 'harvest_qty',
            'filter_field'          => 'created_at',
            'filter_period'         => 'month',
            'group_by_field_format' => 'd.m.Y H:i:s',
            'column_class'          => 'col-md-3',
            'entries_number'        => '5',
            'translation_key'       => 'harvest',
        ];

        $settings14['total_number'] = 0;
        if (class_exists($settings14['model'])) {
            $settings14['total_number'] = $settings14['model']::when(isset($settings14['filter_field']), function ($query) use ($settings14) {
                if (isset($settings14['filter_days'])) {
                    return $query->where($settings14['filter_field'], '>=',
                now()->subDays($settings14['filter_days'])->format('Y-m-d'));
                }
                if (isset($settings14['filter_period'])) {
                    switch ($settings14['filter_period']) {
                case 'week': $start = date('Y-m-d', strtotime('last Monday')); break;
                case 'month': $start = date('Y-m') . '-01'; break;
                case 'year': $start = date('Y') . '-01-01'; break;
            }
                    if (isset($start)) {
                        return $query->where($settings14['filter_field'], '>=', $start);
                    }
                }
            })
                ->{$settings14['aggregate_function'] ?? 'count'}($settings14['aggregate_field'] ?? '*');
        }

        $settings15 = [
            'chart_title'           => 'This Year',
            'chart_type'            => 'number_block',
            'report_type'           => 'group_by_date',
            'model'                 => 'App\Models\Harvest',
            'group_by_field'        => 'created_at',
            'group_by_period'       => 'day',
            'aggregate_function'    => 'sum',
            'aggregate_field'       => 'harvest_qty',
            'filter_field'          => 'created_at',
            'filter_period'         => 'year',
            'group_by_field_format' => 'd.m.Y H:i:s',
            'column_class'          => 'col-md-3',
            'entries_number'        => '5',
            'translation_key'       => 'harvest',
        ];

        $settings15['total_number'] = 0;
        if (class_exists($settings15['model'])) {
            $settings15['total_number'] = $settings15['model']::when(isset($settings15['filter_field']), function ($query) use ($settings15) {
                if (isset($settings15['filter_days'])) {
                    return $query->where($settings15['filter_field'], '>=',
                now()->subDays($settings15['filter_days'])->format('Y-m-d'));
                }
                if (isset($settings15['filter_period'])) {
                    switch ($settings15['filter_period']) {
                case 'week': $start = date('Y-m-d', strtotime('last Monday')); break;
                case 'month': $start = date('Y-m') . '-01'; break;
                case 'year': $start = date('Y') . '-01-01'; break;
            }
                    if (isset($start)) {
                        return $query->where($settings15['filter_field'], '>=', $start);
                    }
                }
            })
                ->{$settings15['aggregate_function'] ?? 'count'}($settings15['aggregate_field'] ?? '*');
        }

        $settings16 = [
            'chart_title'           => 'Harvests',
            'chart_type'            => 'line',
            'report_type'           => 'group_by_date',
            'model'                 => 'App\Models\Harvest',
            'group_by_field'        => 'created_at',
            'group_by_period'       => 'day',
            'aggregate_function'    => 'sum',
            'aggregate_field'       => 'harvest_qty',
            'filter_field'          => 'created_at',
            'filter_period'         => 'year',
            'group_by_field_format' => 'd.m.Y H:i:s',
            'column_class'          => 'col-md-6',
            'entries_number'        => '5',
            'translation_key'       => 'harvest',
        ];

        $chart16 = new LaravelChart($settings16);

        $settings17 = [
            'chart_title'           => 'Sales',
            'chart_type'            => 'bar',
            'report_type'           => 'group_by_date',
            'model'                 => 'App\Models\CashflowSale',
            'group_by_field'        => 'created_at',
            'group_by_period'       => 'day',
            'aggregate_function'    => 'sum',
            'aggregate_field'       => 'total_price',
            'filter_field'          => 'created_at',
            'group_by_field_format' => 'd.m.Y H:i:s',
            'column_class'          => 'col-md-6',
            'entries_number'        => '5',
            'translation_key'       => 'cashflowSale',
        ];

        $chart17 = new LaravelChart($settings17);

        $settings18 = [
            'chart_title'           => 'Incomes',
            'chart_type'            => 'bar',
            'report_type'           => 'group_by_date',
            'model'                 => 'App\Models\CashflowIncome',
            'group_by_field'        => 'date',
            'group_by_period'       => 'day',
            'aggregate_function'    => 'sum',
            'aggregate_field'       => 'amount',
            'filter_field'          => 'created_at',
            'group_by_field_format' => 'd.m.Y',
            'column_class'          => 'col-md-6',
            'entries_number'        => '5',
            'translation_key'       => 'cashflowIncome',
        ];

        $chart18 = new LaravelChart($settings18);

        $settings19 = [
            'chart_title'           => 'Expenses',
            'chart_type'            => 'bar',
            'report_type'           => 'group_by_date',
            'model'                 => 'App\Models\CashflowExpense',
            'group_by_field'        => 'date',
            'group_by_period'       => 'day',
            'aggregate_function'    => 'sum',
            'aggregate_field'       => 'amount',
            'filter_field'          => 'created_at',
            'group_by_field_format' => 'd.m.Y',
            'column_class'          => 'col-md-6',
            'entries_number'        => '5',
            'translation_key'       => 'cashflowExpense',
        ];

        $chart19 = new LaravelChart($settings19);

        return view('home', compact('chart16', 'chart17', 'chart18', 'chart19', 'settings1', 'settings10', 'settings11', 'settings12', 'settings13', 'settings14', 'settings15', 'settings2', 'settings3', 'settings4', 'settings5', 'settings6', 'settings7', 'settings8', 'settings9'));
    }
}
