<?php

use Encore\Admin\Facades\Admin;

/**
 * Laravel-admin - admin builder based on Laravel.
 * @author z-song <https://github.com/z-song>
 *
 * Bootstraper for Admin.
 *
 * Here you can remove builtin form field:
 * Encore\Admin\Form::forget(['map', 'editor']);
 *
 * Or extend custom form field:
 * Encore\Admin\Form::extend('php', PHPEditor::class);
 *
 * Or require js and css assets:
 * Admin::css('/packages/prettydocs/css/styles.css');
 * Admin::js('/packages/prettydocs/js/main.js');
 *
 */

Encore\Admin\Form::forget(['map', 'editor']);

Admin::css('/css/common.css');
Admin::css('/vendor/datatable/dataTables.bootstrap.css');
Admin::css('/vendor/datatable/buttons.bootstrap.min.css');

Admin::js('/js/common.js');
Admin::js('/vendor/chartjs/Chart.min.js');
Admin::js('/vendor/datatable/jquery.dataTables.min.js');
Admin::js('/vendor/datatable/dataTables.sort.plungin.js');
Admin::js('/vendor/datatable/dataTables.bootstrap.min.js');
Admin::js('/vendor/datatable/dataTables.buttons.min.js');
Admin::js('/vendor/datatable/buttons.print.min.js');
Admin::js('/vendor/datatable/jszip.min.js');
Admin::js('/vendor/datatable/buttons.html5.min.js');

Admin::js('/vendor/datatable/buttons.flash.min.js');
