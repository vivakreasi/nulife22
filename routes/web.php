<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();

//Route::name('plan.b.seed')->get('/seed', 'PlanBSeedController@seedPlanB');


//  replace base login
Route::name('login')->get('/login', function() {
    return redirect()->route('home');
});

Route::name('home')->get('/', 'HomeController@welcome');
Route::name('coc')->get('/coc', 'HomeController@showCoc');
Route::name('newlogin')->post('/newlogin', 'MemberController@newLogin');
//Route::name('generate.pin')->get('/generatepin', 'TestController@generatePin');
Route::name('convert.pin')->get('/convertpin', 'TestController@convertPin');
Route::name('dashboard')->get('/dashboard', 'PlanController@index')->middleware('auth');
//Register new anggota inside member
Route::name('new.register')->get('/new/register', 'MemberController@getNewRegister')->middleware('auth');
Route::name('new.register')->post('/new/register', 'MemberController@postNewRegister')->middleware('auth');

//Profile Member
Route::name('my.profile')->get('/my/profile', 'MemberController@getMyProfile')->middleware('auth');
Route::name('new.profile')->get('/new/profile', 'MemberController@getNewProfile')->middleware('auth');
Route::name('new.profile')->post('/new/profile', 'MemberController@postNewProfile')->middleware('auth');
Route::name('edit.profile')->get('/edit/profile/{type}', 'MemberController@getEditProfile')->middleware('auth');
Route::name('edit.profile.post')->post('/edit/profile', 'MemberController@postEditProfile')->middleware('auth');

//Agung Punya jgn diomelin.
Route::name('city.ajax')->get('/city/ajax/{id?}', 'TestController@getCityByProvince')->middleware('auth');
Route::name('city2.ajax')->get('/city2/ajax/{id?}', 'TestController@getCityByProvince2')->middleware('auth');

Route::name('view.member.news')->get('/view/news/{id}', 'MemberController@getMemberViewNews')->middleware('auth');

/*
 * Route untuk modul Plan-a / b
 * @prefix      : plan     --> /plan/***
 * @middleware  : 'auth'    --> route ini hanya bisa diakses oleh member setelah login
 */
Route::prefix('plan')->middleware('auth')->group(function () {
    //  member
    Route::name('plan.direct.sponsor')->get('/sponsored', 'PlanController@directSponsored');
    Route::name('plan.direct.sponsor.ajax')->get('/sponsored/ajax', 'PlanController@ajaxDirectSponsored');
    Route::name('plan.placement')->get('/placement/{from?}/{top?}', 'PlanController@memberPlacement');
    Route::name('plan.placement.post')->post('/placement/do', 'PlanController@doMemberPlacement');
    //placement plan-b
    Route::name('plan.placement.b')->get('/placement-b/{from?}/{top?}', 'PlanBController@memberPlacement');
    Route::name('plan.placement.b.post')->post('/placement-b/do', 'PlanBController@doMemberPlacement');

    //  network
    Route::name('plan.network.binary')->get('/network/binary/{from?}/{top?}', 'PlanController@getNetworkBinaryStructure');
    Route::name('plan.network.level')->get('/network/level/{from?}', 'PlanController@getNetworkLevelStructure');
    Route::name('plan.network.binary.b')->get('/network/planb-binary/{from?}/{top?}', 'PlanBController@getNetworkBinaryStructure');
    //  upgrade to B
    Route::name('plan.upgrade.b')->get('/member/upgrade', 'PlanController@upgradeToB');
    Route::name('plan.upgrade.b')->post('/member/upgrade', 'PlanController@upgradeToB');
    Route::name('plan.upgrade.b.image')->get('/image/upgrade', 'ImageController@showImageUpgradePlanB');
    // claim product
    Route::name('plan.product.claim')->get('/product/claim', 'PlanController@claimProduct');
    Route::name('plan.product.claimb')->get('/product/claim/b/{code}', 'PlanController@getClaimProductB');
    Route::name('plan.product.postclaimb')->post('/product/claim/b', 'PlanController@postClaimProductB');
    Route::name('plan.product.claimc')->get('/product/claim/c/{code}', 'PlanController@getClaimProductC');
    Route::name('plan.product.postclaimc')->post('/product/claim/c', 'PlanController@postClaimProductC');

});
/*
 * Route untuk modul bonus
 * @prefix      : bonus     --> /bonus/***
 * @middleware  : 'auth'    --> route ini hanya bisa diakses oleh member setelah login
 */
Route::prefix('bonus')->middleware('auth')->group(function () {
    //  bonus
    Route::name('bonus')->get('/', 'BonusController@index');
    Route::name('bonus.ajax')->get('/summary/ajax', 'BonusController@ajaxIndexBonus');
    Route::name('bonus.sponsor')->get('/sponsor', 'BonusController@bonusSponsor');
    Route::name('bonus.sponsor.ajax')->get('/sponsor/ajax', 'BonusController@ajaxBonusSponsor');
    Route::name('bonus.pairing')->get('/pairing', 'BonusController@bonusPairing');
    Route::name('bonus.pairing.ajax')->get('/pairing/ajax', 'BonusController@ajaxBonusPairing');
    Route::name('bonus.upgrade.b')->get('/upgrade-b', 'BonusController@bonusUpgradeB');
    Route::name('bonus.upgrade.b.ajax')->get('/upgrade-b/ajax', 'BonusController@ajaxBonusUpgradeB');
    Route::name('bonus.reward')->get('/reward', 'BonusController@bonusReward');
    Route::name('bonus.reward.ajax')->get('/reward/ajax/{plan}', 'BonusController@ajaxBonusReward');
    Route::name('bonus.reward.claim')->get('/reward/claim/{id}/{plan}', 'BonusController@claimBonusReward');
    Route::name('bonus.reward.claim')->post('/reward/claim/{id}/{plan}', 'BonusController@claimBonusReward');
    //  previous bonus, 4 juli 2017
    Route::name('bonus.previous')->get('/prev', 'BonusController@previousIndex');
    Route::name('bonus.previous.ajax')->get('/prev-summary/ajax', 'BonusController@ajaxPreviousIndexBonus');
    Route::name('bonus.sponsor.previous')->get('/prev-sponsor', 'BonusController@previousBonusSponsor');
    Route::name('bonus.sponsor.previous.ajax')->get('/prev-sponsor/ajax', 'BonusController@ajaxPreviousBonusSponsor');
    Route::name('bonus.pairing.previous')->get('/prev-pairing', 'BonusController@previousBonusPairing');
    Route::name('bonus.pairing.previous.ajax')->get('/prev-pairing/ajax', 'BonusController@ajaxPreviousBonusPairing');
    Route::name('bonus.upgrade.b.previous')->get('/prev-upgrade-b', 'BonusController@previousBonusUpgradeB');
    Route::name('bonus.upgrade.b.previous.ajax')->get('/prev-upgrade-b/ajax', 'BonusController@ajaxPreviousBonusUpgradeB');
});
/*
 * Route untuk modul nu-cash
 * @prefix      : nucash     --> /nucash/***
 * @middleware  : 'auth'    --> route ini hanya bisa diakses oleh member setelah login
 */
Route::prefix('nucash')->middleware('auth')->group(function () {
    //  bonus
    Route::name('nucash')->get('/', 'NuCashController@listNuCash');
    Route::name('nucash.ajax')->get('/ajax', 'NuCashController@ajaxListNuCash');
    Route::name('nucash.wd')->get('/withdrawal', 'NuCashController@withdrawal');
    Route::name('nucash.wd')->post('/withdrawal', 'NuCashController@withdrawal');
    Route::name('nucash.wd.list')->get('/withdrawal/list', 'NuCashController@getListWithdrawal');
    Route::name('nucash.wd.ajax')->get('/withdrawal/ajax', 'NuCashController@getAjaxWithdrawal');
    Route::name('nucash.previous.list')->get('/previous/list', 'NuCashController@getListPrevious');
    Route::name('nucash.previous.ajax')->get('/previous/ajax', 'NuCashController@getAjaxPrevious');
    Route::name('nucash.confirm.member.wd')->post('/nucash/member-confirm/wd', 'NuCashController@confirmNucashWD');
    Route::name('nucash.confirm.member.wd.checked')->post('/nucash/confirm/wd-checked', 'NuCashController@confirmCheckedNucashWD');
});
/*
 * Route untuk modul nu-cash
 * @prefix      : nucash     --> /nucash/***
 * @middleware  : 'auth'    --> route ini hanya bisa diakses oleh member setelah login
 */
Route::prefix('nupoint')->middleware('auth')->group(function () {
    //  bonus
    Route::name('nupoint')->get('/', 'NuPointController@listNuPoint');
    Route::name('nupoint.ajax')->get('/ajax', 'NuPointController@ajaxListNuPoint');
    Route::name('nupoint.market')->get('/market-place', 'NuPointController@marketPlace');
    Route::name('nupoint.market')->post('/market-place', 'NuPointController@marketPlace');
});
/*
 * Route untuk modul Plan-C
 * @prefix      : planc     --> /planc/***
 * @middleware  : 'auth'    --> route ini hanya bisa diakses oleh member setelah login
 */
Route::prefix('planc')->middleware('auth')->group(function () {
    //  dashboard
    Route::name('planc')->get('/', 'PlanCController@index');
    Route::name('planc.ajax.queue')->get('/ajax/queue', 'PlanCController@ajaxQueue');
    //  join
    Route::name('planc.join')->get('/join', 'PlanCController@join');
    Route::name('planc.dojoin')->post('/join', 'PlanCController@join');
    //  status
    Route::name('planc.status.order')->get('/status', 'PlanCController@statusOrder');
    //  order pin
    Route::name('planc.trfinstruction')->get('/trfinstruction', 'PlanCController@transferInstruction');
    Route::name('planc.trfinstruction')->post('/trfinstruction', 'PlanCController@transferInstruction');
    Route::name('planc.uploadbukti')->post('/upload', 'PlanCController@uploadBuktiTransfer');
    //  bonus list
    Route::name('planc.bonus')->get('bonus', 'PlanCController@bonusList');
    Route::name('planc.bonus.success')->get('bonus/success', 'PlanCController@bonusSuccessList');
    Route::name('planc.bonus.leadership')->get('bonus-leadership', 'PlanCController@bonusListLeadership');
    Route::name('planc.bank')->get('bank', 'PlanCController@userBank');
    Route::name('planc.bank.add')->get('bank/add', 'PlanCController@addUserBank');
    Route::name('planc.bank.add')->post('bank/add', 'PlanCController@addUserBank');
    Route::name('planc.bank.edit')->get('bank/edit/{id}', 'PlanCController@editUserBank');
    Route::name('planc.bank.edit')->post('bank/edit/{id}', 'PlanCController@editUserBank');
    // image
    Route::name('planc.pin.image')->get('/image/pinplanc/', 'ImageController@showImagePinPlanC');
    //  history
    Route::name('planc.history')->get('/history', 'PlanCController@historyPlan');
});

Route::prefix('planb')->middleware('auth')->group(function () {
    //  join
    Route::name('planb.join')->get('/join', 'PlanCController@join');
    Route::name('planb.postjoin')->post('/join', 'PlanCController@join');
});

Route::prefix('admin')->middleware('auth')->group(function () {
    //  dashboard
    Route::name('admin')->get('/', 'AdminController@index');
    // List Order PIN Plan-C Unconfirmed/Confirmed
    Route::name('admin.pinc.order')->get('/plan-c/order', 'AdminController@listOrderC');
    Route::name('admin.ajax.pinc.payment')->get('/plan-c/ajax/payment', 'AdminController@ajaxListPaymentC');
    Route::name('admin.ajax.pinc.order')->get('/plan-c/ajax/order', 'AdminController@ajaxListOrderC');
    Route::name('admin.pinc.order.post')->post('/plan-c/order', 'AdminController@updateOrderC');
    Route::name('admin.pinc.order.manual.confirm')->post('/plan-c/order/manual', 'AdminController@manualConfirmOrderC');
    // List Order PIN Plan-C With Address
    Route::name('admin.pinc.order.address')->get('/plan-c/order/with-address', 'AdminController@listOrderCWithAddress');
    Route::name('admin.ajax.pinc.order.address')->get('/plan-c/ajax/order/with-address', 'AdminController@ajaxListOrderCWithAddress');
    // List wd bonus plan-c
    Route::name('admin.planc.wd')->get('/plan-c/wd', 'AdminController@listPlancWD');
    Route::name('admin.ajax.planc.wd')->get('/plan-c/ajax/wd', 'AdminController@ajaxListPlancWD');
    Route::name('admin.confirm.planc.wd')->post('/plan-c/confirm/wd', 'AdminController@confirmWD');
    Route::name('admin.confirm.planc.wd.checked')->post('/plan-c/confirm/wd-checked', 'AdminController@confirmCheckedWD');
    Route::name('admin.reject.planc.wd')->post('/plan-c/reject/wd', 'AdminController@rejectWD');
    Route::name('admin.excel.planc.wd')->get('/plan-c/exportexcel/wd/{status}','AdminController@downloadListWdExcel');
    Route::name('admin.excel.planc.wdpayroll')->get('/plan-c/exportexcel/wdpayroll','AdminController@downloadListWdPayrollExcel');
    Route::name('admin.planc.wd.report')->get('/plan-c/wd/report', 'AdminController@reportPlancWD');
    Route::name('admin.ajax.planc.wd.report')->get('/plan-c/ajax/wd/report', 'AdminController@ajaxReportPlancWD');
    // List wd bonus leadership plan-c
    Route::name('admin.planc.wd.leadership')->get('/plan-c/wd/leadership', 'AdminController@listPlancBonusLeadershipWD');
    Route::name('admin.ajax.planc.wd.leadership')->get('/plan-c/ajax/wd/leadership', 'AdminController@ajaxListPlancBonusLeadershipWD');
    Route::name('admin.confirm.planc.wd.leadership')->post('/plan-c/confirm/wd/leadership', 'AdminController@confirmBonusLeadershipWD');
    Route::name('admin.confirm.planc.wd.leadership.checked')->post('/plan-c/confirm/wd-checked/leadership', 'AdminController@confirmCheckedBonusLeadershipWD');
    Route::name('admin.reject.planc.wd.leadership')->post('/plan-c/reject/wd/leadership', 'AdminController@rejectBonusLeadershipWD');
    Route::name('admin.excel.planc.wd.leadership')->get('/plan-c/exportexcel/wd/leadership/{status}','AdminController@downloadListBonusLeadershipWdExcel');
    Route::name('admin.excel.planc.wdpayroll.leadership')->get('/plan-c/exportexcel/leadership/wdpayroll','AdminController@downloadListBonusLeadershipWdPayrollExcel');
    Route::name('admin.planc.wd.leadership.report')->get('/plan-c/wd/leadership/report', 'AdminController@reportPlancBonusLeadershipWD');
    Route::name('admin.ajax.planc.wd.leadership.report')->get('/plan-c/ajax/wd/leadership/report', 'AdminController@ajaxReportPlancBonusLeadershipWD');
    // List Join Plan-C
    Route::name('admin.planc.join.report')->get('/plan-c/join/report', 'AdminController@reportPlancJoin');
    Route::name('admin.ajax.planc.join.report')->get('/ajax/plan-c/join/report/{days?}', 'AdminController@ajaxReportPlancJoin');
    // Claim Plan-C
    Route::name('admin.planc.claimc')->get('/planc/product/claimc', 'AdminController@productClaimC');
    Route::name('admin.ajax.planc.claimc')->get('/ajax/planc/product/claimc', 'AdminController@ajaxListProductClaimC');
    Route::name('admin.excel.planc.claimc')->get('/planc/exportexcel/claimc/{type}/{status}','AdminController@downloadListClaimC');
    // Plan-A setting
    Route::name('admin.plana.setting')->get('/plan-a/setting', 'AdminController@settingPlanA');
    Route::name('admin.plana.setting')->post('/plan-a/setting', 'AdminController@settingPlanA');
    // Plan-B setting
    Route::name('admin.planb.setting')->get('/plan-b/setting', 'AdminController@settingPlanB');
    Route::name('admin.planb.setting')->post('/plan-b/setting', 'AdminController@settingPlanB');
    // Reward Plan-A/B setting
    Route::name('admin.reward.setting')->get('/reward/setting', 'AdminController@rewardSetting');
    Route::name('admin.reward.setting.add')->get('/reward/setting/add', 'AdminController@addRewardSetting');
    Route::name('admin.reward.setting.add')->post('/reward/setting/add', 'AdminController@addRewardSetting');
    Route::name('admin.reward.setting.edit')->get('/reward/setting/edit/{id}', 'AdminController@editRewardSetting');
    Route::name('admin.reward.setting.edit')->post('/reward/setting/edit/{id}', 'AdminController@editRewardSetting');
    Route::name('admin.reward.ajax.setting')->get('/reward/ajax/setting', 'AdminController@ajaxRewardSetting');
    // Plan-C setting
    Route::name('admin.planc.setting')->get('/plan-c/setting', 'AdminController@settingPlanC');
    Route::name('admin.planc.setting')->post('/plan-c/setting', 'AdminController@settingPlanC');
    // Partner setting
    Route::name('admin.partner.setting')->get('/partner/setting', 'AdminController@settingPartner');
    Route::name('admin.partner.setting')->post('/partner/setting', 'AdminController@settingPartner');
    // PIN setting
    Route::name('admin.pin.setting')->get('/pin/setting', 'AdminController@settingPin');
    Route::name('admin.pin.setting')->post('/pin/setting', 'AdminController@settingPin');
    // List bank company
    Route::name('admin.company.bank')->get('/company/bank', 'AdminController@listCompanyBank');
    Route::name('admin.company.ajax.bank')->get('/company/ajax/bank', 'AdminController@ajaxListCompanyBank');
    Route::name('admin.company.bank.add')->get('/company/bank/add', 'AdminController@addCompanyBank');
    Route::name('admin.company.bank.add')->post('/company/bank/add', 'AdminController@addCompanyBank');
    Route::name('admin.company.bank.update')->post('/company/bank/update', 'AdminController@updateCompanyBank');
    Route::name('admin.company.bank.edit')->get('/company/bank/edit/{id}', 'AdminController@getEditCompanyBank');
    Route::name('admin.company.bank.edit.post')->post('/company/bank/edit', 'AdminController@postEditCompanyBank');
    // List request upgrade to plan-B
    Route::name('admin.plan.upgrade')->get('/plan/upgrade-b', 'AdminController@listPlanUpgradeB');
    Route::name('admin.ajax.plan.upgrade')->get('/plan/ajax/upgrade-b', 'AdminController@ajaxListPlanUpgradeB');
    Route::name('admin.confirm.plan.upgrade')->post('/plan/confirm/upgrade-b', 'AdminController@confirmPlanUpgradeB');
    // List claim reward plan-A/B
    Route::name('admin.plan.reward')->get('/plan/reward', 'AdminController@listClaimReward');
    Route::name('admin.ajax.plan.reward')->get('/plan/ajax/reward', 'AdminController@ajaxListClaimReward');
    Route::name('admin.confirm.plan.reward')->post('/plan/confirm/reward', 'AdminController@confirmClaimReward');
    //WD Nucash
    Route::name('admin.nucash.wd.list')->get('/nucash/wd-list', 'AdminController@getListNucashWD');
    Route::name('admin.nucash.wd.ajax')->get('/nucash/wd-ajax', 'AdminController@getAjaxListNucashWD');
    Route::name('admin.confirm.nucash.wd')->post('/nucash/confirm/wd', 'AdminController@confirmNucashWD');
    //Route::name('admin.confirm.nucash.wd.checked')->post('/nucash/confirm/wd-checked', 'AdminController@confirmCheckedNucashWD');
    Route::name('admin.nucash.xls')->get('/nucash/export/xls', 'AdminController@getExcelNucashWD');
    Route::name('admin.nucash.xls.payroll')->get('/nucash/export/xls-payroll', 'AdminController@getExcelNucashPayrollWD');
    //PIN Activation
    Route::name('admin.pin.list')->get('/pin/list', 'AdminController@getListActivationPIN');
    Route::name('admin.pin.ajax')->get('/pin/ajax', 'AdminController@getAjaxActivationPIN');
    Route::name('admin.pin.report')->get('/pin/report', 'AdminController@reportPin');
    Route::name('admin.pin.report.ajax')->get('/pin/report/ajax', 'AdminController@ajaxReportPin');
    Route::name('admin.pin.report.ajax.used')->get('/pin/report/ajax-used/{id}', 'AdminController@ajaxReportPinUsedActive');
    Route::name('admin.pin.report.xls')->get('/pin/report/xls', 'AdminController@getExcelReportPin');
    Route::name('admin.pin.generate')->get('/pin/generate/{userid}/{type}/{pin}', 'AdminController@generatePin');
    //Member
    Route::name('admin.member.list')->get('/member/list', 'AdminController@getListAllMembers');
    Route::name('admin.member.ajax')->get('/member/ajax', 'AdminController@getAjaxAllMembers');
    Route::name('admin.planbmember.list')->get('/planbmember/list', 'AdminController@getListPlanBMembers');
    Route::name('admin.planbmember.ajax')->get('/planbmember/ajax', 'AdminController@getAjaxPlanBMembers');
    Route::name('admin.view.member')->get('/view/member/{id}', 'AdminController@getViewMember');
    Route::name('admin.isactive.member')->get('/active/member/{id}', 'AdminController@getChangeIsActiveMembers');
    Route::name('admin.edit.member')->get('/edit/member/{type}/{id}', 'AdminController@getEditMemberByType');
    Route::name('admin.edit.member.post')->post('/edit/member/', 'AdminController@postEditMemberByType');
    Route::name('admin.member.genealogy')->get('/member/genealogy/{from?}/{top?}', 'AdminController@viewGenealogy');
    //Ajax Structure
    Route::name('admin.ajax.structure')->get('/ajax/structure/{id}', 'AdminController@getAjaxStructure');
    //  list stockist
    Route::name('admin.partner.list')->get('/partner/list', 'AdminController@getListPartner');
    Route::name('admin.partner.list.ajax')->get('/partner/list/ajax', 'AdminController@getAjaxListPartner');
    Route::name('admin.partner.downgrade')->post('/partner/downgrade', 'AdminController@downgradePartner');
    //  pengen jadi stockist
    Route::name('admin.partner.become')->get('/partner/request', 'AdminController@getListBecomePartner');
    Route::name('admin.partner.become.ajax')->get('/partner/request/ajax', 'AdminController@getAjaxListBecomePartner');
    Route::name('admin.partner.confirm')->post('/partner/confirm', 'AdminController@confirmBecomePartner');
    // Inventory
    /*Route::name('admin.inventory.product')->get('/inventory/product', 'AdminController@invProductList');
    Route::name('admin.inventory.claima')->get('/inventory/claima', 'AdminController@invProductClaimA');
    Route::name('admin.inventory.claimb')->get('/inventory/claimb', 'AdminController@invProductClaimB');
    Route::name('admin.inventory.claimc')->post('/company/claimc', 'AdminController@invProductClaimC');*/
    // Member belum withdrawal
    Route::name('admin.member.not.wd.list')->get('/member/not/wd-list', 'AdminController@getListMemberNotWD');
    Route::name('admin.member.not.wd.ajax')->get('/member/not/wd-ajax', 'AdminController@getAjaxListMemberNotWD');
    Route::name('admin.member.not.wd.detailajax')->get('/member/not/detail/wd-ajax/{id}', 'AdminController@getAjaxListMemberNotUserWD');
    Route::name('admin.member.not.wd.xls')->get('/member/not/export/xls/{no}', 'AdminController@getExcelMemberNotWD');
    //Menu Report Rewards Global
    Route::name('admin.report.reward.global')->get('/report/reward/global', 'AdminController@getRewardGlobal');
    Route::name('admin.report.reward.global.xls')->get('/report/reward/global-xls', 'AdminController@getRewardGlobalXLS');
    Route::name('admin.report.bonus.global')->get('/report/bonus/global', 'AdminController@getBonusGlobal');
    Route::name('admin.report.bonus.global.xls')->get('/report/bonus/global-xls', 'AdminController@getBonusGlobalXLS');
    //Menu News
    Route::name('admin.list.news')->get('/list/news', 'AdminController@getAdminListNews');
    Route::name('admin.news')->get('/news', 'AdminController@getAdminNews');
    Route::name('admin.news.post')->post('/news', 'AdminController@postAdminNews');
    Route::name('admin.edit.news')->get('/edit/news/{id}', 'AdminController@getAdminEditNews');
    Route::name('admin.edit.news.post')->post('/edit/news', 'AdminController@postAdminEditNews');
    Route::name('admin.delete.news')->get('/delete/news/{id}/{type}', 'AdminController@getAdminDeleteNews');

    // Inventory Settings
    Route::name('admin.inventory.metric')->get('/inventory/metric', 'InventoryController@getMetric');
    Route::name('admin.inventory.metricform')->get('/inventory/metricform/{mode}/{id}', 'InventoryController@getMetricForm');
    Route::name('admin.inventory.metricformpost')->post('/inventory/metricformpost', 'InventoryController@postMetricForm');
    Route::name('admin.inventory.category')->get('/inventory/category', 'InventoryController@getCategory');
    Route::name('admin.inventory.categoryform')->get('/inventory/categoryform/{mode}/{id}', 'InventoryController@getCategoryForm');
    Route::name('admin.inventory.categoryformpost')->post('/inventory/categoryformpost', 'InventoryController@postCategoryForm');
    Route::name('admin.inventory.item')->get('/inventory/item', 'InventoryController@getItem');
    Route::name('admin.inventory.itemform')->get('/inventory/itemform/{mode}/{id}', 'InventoryController@getItemForm');
    Route::name('admin.inventory.itemformpost')->post('/inventory/itemformpost', 'InventoryController@postItemForm');
    Route::name('admin.inventory.location')->get('/inventory/location', 'InventoryController@getLocation');
    Route::name('admin.inventory.locationform')->get('/inventory/locationform/{mode}/{id}', 'InventoryController@getLocationForm');
    Route::name('admin.inventory.locationformpost')->post('/inventory/locationformpost', 'InventoryController@postLocationForm');
    Route::name('admin.inventory.supplier')->get('/inventory/supplier', 'InventoryController@getSupplier');
    Route::name('admin.inventory.supplierform')->get('/inventory/supplierform/{mode}/{id}', 'InventoryController@getSupplierForm');
    Route::name('admin.inventory.supplierformpost')->post('/inventory/supplierformpost', 'InventoryController@postSupplierForm');
    //Inventory
    Route::name('admin.inventory.stock')->get('/inventory/stock', 'InventoryController@stockStanding');
    Route::name('admin.inventory.stockadd')->get('/inventory/stockadd', 'InventoryController@addStock');
    Route::name('admin.inventory.stockaddpost')->post('/inventory/stockaddpost', 'InventoryController@postAddStock');
    Route::name('admin.inventory.stockmove')->get('/inventory/stockmove', 'InventoryController@moveStock');
    Route::name('admin.inventory.claimb')->get('/inventory/product/claimb', 'InventoryController@productClaimB');
    Route::name('admin.ajax.inventory.claimb')->get('/ajax/inventory/product/claimb', 'InventoryController@ajaxListProductClaimB');
    Route::name('admin.excel.inventory.claimb')->get('/inventory/exportexcel/claimb/{type}/{status}','AdminController@downloadListClaimB');
    Route::name('admin.inventory.claimc')->get('/inventory/product/claimc', 'InventoryController@productClaimC');
    //Bank Admin Max
    Route::name('admin.max.bank')->get('/max/bank', 'AdminController@getAdminMaxBank');
    Route::name('admin.max.bank.post')->post('/max/bank', 'AdminController@postAdminMaxBank');
    //  member with left right
    Route::name('admin.member.leftright')->get('/member/leftright', 'AdminController@getListMemberLeftRight');
    Route::name('admin.member.leftright.ajax')->get('/ajax/member/leftright', 'AdminController@getAjaxListMemberLeftRight');
});

//Referal Link
Route::name('get.referal')->get('/r/{code}', 'ReferalController@getReferalLink');
Route::name('post.referal')->post('/referal-link', 'ReferalController@postReferalLink');
Route::name('get.aktivasi')->get('/activation/{code}', 'ReferalController@getActivation');
////Route::name('sync')->get('/sync', 'ReferalController@getSync');

//hak usaha
Route::name('hakusaha')->get('/hakusaha', 'MemberController@getHakUsaha')->middleware('auth');
Route::name('hakusaha.post')->post('/hakusaha/{type}', 'MemberController@postHakUsaha')->middleware('auth');

//Add Bank member
Route::name('create.bank')->get('/create/bank', 'MemberController@getAddBankMember')->middleware('auth');
Route::name('post.create.bank')->post('/create/bank', 'MemberController@postAddBankMember')->middleware('auth');
Route::name('edit.bank')->get('/edit/bank/{id}', 'MemberController@getEditBankMember')->middleware('auth');
Route::name('edit.bank.post')->post('/edit/bank', 'MemberController@postEditBankMember')->middleware('auth');

//Transfer to Referal via referal
Route::name('post.transfer.referal')->post('/ref/transfer', 'MemberController@postTransferToReferal');

//Confirm from referal indeed transfer from downline
Route::name('list.referal')->get('/list/transfer', 'MemberController@getListTransferReferal')->middleware('auth');
Route::name('confirm.referal')->get('/confirm/transfer/{id}', 'MemberController@getConfirmTransferReferal')->middleware('auth');
Route::name('img.referal')->get('/img/transfer/{img}', 'ImageController@showImageTransferReferal')->middleware('auth');
Route::name('post.confirm.referal')->post('/confirm/transfer', 'MemberController@postConfirmTransferReferal')->middleware('auth');

//News View Member Area
Route::name('news.member.list')->get('/list/news/member', 'MemberController@getMemberListNews')->middleware('auth');
Route::name('news.member.detail')->get('/detail/news/member/{id}', 'MemberController@getMemberDetailNews')->middleware('auth');

//Forget Password
Route::name('lost.password')->get('/forgot/password', 'PasswordController@getLostPassword');
Route::name('post.lost.password')->post('/forgot/password', 'PasswordController@postLostPassword');
Route::name('get.activation.password')->get('/password/activation/{code}', 'PasswordController@getActivationPassword');
Route::name('post.activation.password')->post('/password/activation', 'PasswordController@postActivationPassword');

//Resend Activation
Route::name('post.resend.activation')->post('/resend/activation', 'PasswordController@postResendActivation');

//Update pin_code users
Route::name('update.pin.code.manually')->get('/update_pin_code_nulife', 'ReferalController@updatePinCode');


/*
 * Route untuk modul Pin
 * @prefix      : pin     --> /pin/***
 * @middleware  : 'auth'    --> route ini hanya bisa diakses oleh member setelah login
 */
Route::prefix('pin')->middleware('auth')->group(function () {
    Route::name('pin.my')->get('/my', 'PinController@myPin');
    Route::name('pin.ajax.my')->get('/ajax/my', 'PinController@ajaxListMy');
    Route::name('pin.order')->get('/order', 'PinController@orderPin');
    Route::name('pin.order')->post('/order', 'PinController@orderPin');
    Route::name('pin.buy')->post('/buy', 'PinController@buyPin');
    Route::name('pin.transfer')->post('/transfer', 'PinController@transferPin');
    Route::name('pin.list')->get('/list', 'PinController@listOrder');
    Route::name('pin.ajax.list')->get('/ajax/list', 'PinController@ajaxListOrder');
    Route::name('pin.invoice')->get('/invoice/{transaction_code}', 'PinController@invoicePin');
    Route::name('pin.order.post')->post('/order/post', 'PinController@orderPinPost');
    Route::name('pin.confirm')->post('/confirm', 'PinController@confirmOrder');
    Route::name('pin.confirm.image')->get('/image/confirm', 'ImageController@showImageConfirmPin');
    Route::name('pin.ajax.getdatauser')->get('/ajax-getdatauser/{userid}/{is_id}', 'PinController@getdatauser');
    //  previous pin, converted, old pin
    Route::name('pin.previous')->get('/previous', 'PinController@previousPin');
    Route::name('pin.ajax.previous')->get('/ajax/previous', 'PinController@ajaxPreviousPin');
});
#
#
#Route::get('/referal-link/{code}', 'ActivationController@getReferalLink');


//Modul Stockist
Route::prefix('partner')->middleware('auth')->group(function () {
    Route::name('partner.status')->get('/status', 'StockistController@statusPartner');
    Route::name('partner.join')->get('/join', 'StockistController@joinPartner');
    Route::name('partner.join')->post('/join', 'StockistController@joinPartner');
    Route::name('partner.upgrade')->get('/upgrade', 'StockistController@upgradePartner');
    Route::name('partner.upgrade')->post('/upgrade', 'StockistController@upgradePartner');
    Route::name('partner.invoice')->get('/invoice', 'StockistController@invoicePartner');
    Route::name('partner.upload')->get('/upload', 'StockistController@uploadPartner');
    Route::name('partner.upload')->post('/upload', 'StockistController@uploadPartner');
    Route::name('partner.image')->get('/image', 'ImageController@showImageBecomePartner');
});

