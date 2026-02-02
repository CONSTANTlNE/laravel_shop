<?php

use App\Http\Controllers\WayBillController;

Route::prefix('admin')
    ->where(['locale' => '[a-zA-Z]{2}'])
    ->middleware(['auth:admin'])
    ->group(function () {

        Route::get('users', [WayBillController::class, 'getServiceUsers'])->name('users');
        Route::get('checkseller', [WayBillController::class, 'checkuser'])->name('checkseller');
        Route::get('types', [WayBillController::class, 'gettypes'])->name('types');
        Route::get('transptypes', [WayBillController::class, 'getTransTypes'])->name('transtypes');
        Route::get('units', [WayBillController::class, 'getunits'])->name('units');
        Route::get('savewaybill2', [WayBillController::class, 'saveWaybill2'])->name('savewaybill2');
        Route::get('codes', [WayBillController::class, 'geterror'])->name('geterror');
        Route::get('zreport', [WayBillController::class, 'zreportdetails'])->name('zreportdetails');
        Route::get('cash', [WayBillController::class, 'cash'])->name('cash');
        Route::get('getinvoice', [WayBillController::class, 'getinvoice'])->name('getinvoice');

        Route::controller(WayBillController::class)->group(function () {
            Route::post('waybill/withtransport', 'withTransport')->name('waybill.with.transport');
            Route::post('waybill/finish', 'finish')->name('waybill.finish');
        });

    });
