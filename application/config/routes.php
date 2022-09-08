<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

//API ROUTE
//$route['Api/Login/login'] = 'api/Login/login';
$route['api/login'] = 'Api/auth/Auth/login_api_ci';
$route['api/refresh_token'] = 'Api/auth/Auth/refresh_token_ci';
$route['api/social_login'] = 'Api/auth/Auth/social_login_api_ci';
$route['api/forgot_api'] = 'Api/auth/Auth/forgot_api_ci';
$route['api/change_password'] = 'Api/auth/Auth/change_password_api';
$route['api/profile'] = 'Api/user/Profile/profile_api_ci';
$route['api/profile/update'] = 'Api/user/Profile/profile_api_update_ci';

$route['api/registration'] = 'Api/user/Registration/registration_api_ci';
$route['api/social_registration'] = 'Api/user/Registration/social_registration_api_ci';


//Member Api
$route['api/member/get'] = 'Api/user/Member/member_api_get_ci';
$route['api/member/add'] = 'Api/user/Member/member_api_add_ci';
$route['api/member/update/(:any)'] = 'Api/user/Member/member_api_update_ci';
$route['api/member/delete/(:any)'] = 'Api/user/Member/member_api_delete_ci';
//Member Api

//Appointment Api
//$route['api/doctor/get'] = 'Api/user/Appointment/doctor_api_get_ci';
$route['api/doctor/add'] = 'Api/user/Appointment/doctor_api_add_ci';

$route['api/nurse/add'] = 'Api/user/Appointment/nurse_api_add_ci';
$route['api/lab/add'] = 'Api/user/Appointment/lab_api_add_ci';
$route['api/pharmacy/add'] = 'Api/user/Appointment/pharmacy_api_add_ci';
$route['api/ambulance/one_way'] = 'Api/user/Appointment/ambulance_api_one_way_ci';
$route['api/ambulance/round_trip'] = 'Api/user/Appointment/ambulance_api_round_trip_ci';
$route['api/ambulance/multi_location'] = 'Api/user/Appointment/ambulance_api_multi_location_ci';
//Appointment Api



//Address Api
$route['api/address/get'] = 'Api/user/Address/address_api_get_ci';
$route['api/address/add'] = 'Api/user/Address/address_api_add_ci';
$route['api/address/update/(:any)'] = 'Api/user/Address/address_api_update_ci';
$route['api/address/delete/(:any)'] = 'Api/user/Address/address_api_delete_ci';
//Address Api

//Package Api
$route['api/package/get'] = 'Api/user/Package/package_api_get_ci';
$route['api/package/book'] = 'Api/user/Package/book_package_api_ci';
//Package Api


//My Package
$route['api/mybook_package/get'] = 'Api/user/MybookPackage/my_book_package_api_get_ci';
$route['api/mybook_package/book_visit'] = 'Api/user/MybookPackage/book_visit_api_ci';

$route['api/mybook_package/visit_history/(:any)'] = 'Api/user/MybookPackage/mybook_package_visti_history_ci';
//$route['api/mybook_package/visti_history/get'] = 'Api/user/MybookPackage/mybook_package_visti_history_ci';

//My Package

//Complain Api
$route['api/complain/get'] = 'Api/user/Complain/complain_api_get_ci';
$route['api/complain/add'] = 'Api/user/Complain/complain_api_add_ci';
//Complain Api

//Wallet Api
$route['api/wallet/get'] = 'Api/user/Wallet/wallet_api_get_ci';
$route['api/wallet_deduction/get'] = 'Api/user/Wallet/wallet_deduction_api_get_ci';
//$route['api/wallet/add'] = 'Api/user/Wallet/wallet_api_add_ci';
$route['api/wallet/getWalletPaymentToken'] = 'Api/user/Wallet/getWalletPaymentToken';
$route['api/wallet/setWalletPaymentRequest'] = 'Api/user/Wallet/setWalletPaymentRequest';

//Wallet Api


//Promo Code Api
$route['api/PromoCode/get'] = 'Api/user/PromoCode/promocode_api_get_ci';
$route['api/PromoCode/add'] = 'Api/user/PromoCode/promocode_api_add_ci';
//Promo Code Api
//Share Code Api
$route['api/Share/get'] = 'Api/user/Share/share_api_get_ci';

//Share Code Api

//Notification Code Api
$route['api/Notification/get'] = 'Api/user/Notification/notification_api_send_ci';
$route['api/Notification/getPushNotificationToken'] = 'Api/user/Notification/getPushNotificationToken';
//Notification Code Api

//Terms Api
$route['api/terms_condition'] = 'Api/TermsCondition/terms_condition_api_ci';
//Terms Api

//Privacy and policy Api
$route['api/privacy_policy'] = 'Api/PrivacyPolicy/privacy_policy_api_ci';
//Privacy Api

//About Api
$route['api/about'] = 'Api/About/about_api_ci';
//About Api

//About Api
$route['api/blog'] = 'Api/Blog/blog_api_ci';
//About Api

//About Api
$route['api/help'] = 'Api/Help/help_api_ci';
//About Api

//Feedback Option Api
$route['api/feedback_option'] = 'Api/FeedbackOptions/feedbackoption_api_ci';
//Feedback Option Api

//Feedback Services Api
$route['api/feedback_services'] = 'Api/FeedbackServices/feedbackservices_api_ci';
//Feedback Services Api



//City Api
$route['api/city'] = 'Api/City/city_api_ci';
//City Api

//State Api
$route['api/state'] = 'Api/State/state_api_ci';
//State Api

//State Api
$route['api/country'] = 'Api/Country/country_api_ci';
//State Api

//Doctor Type Api
$route['api/doctor_type'] = 'Api/DoctorType/doctor_type_api_ci';
//Doctor Type Api

//Service Type Api
$route['api/service_type'] = 'Api/ServiceType/service_type_api_ci';
//Service Type Api

//Lab Test Type Api
$route['api/lab_test_type'] = 'Api/LabTestType/lab_test_type_api_ci';
//Lab Test Type Api

//Cart Api
$route['api/cart'] = 'Api/Cart/cart_api_ci';
$route['api/cart/delete/(:any)'] = 'Api/Cart/cart_api_deleted_ci';
$route['api/cart/doc_update/(:any)'] = 'Api/Cart/cart_doctor_api_update_ci';
$route['api/cart/nur_update/(:any)'] = 'Api/Cart/cart_nurse_api_update_ci';
$route['api/cart/lab_update/(:any)'] = 'Api/Cart/cart_lab_api_update_ci';
$route['api/cart/one_way_update/(:any)'] = 'Api/Cart/cart_oneway_api_update_ci';
$route['api/cart/round_trip_update/(:any)'] = 'Api/Cart/cart_round_trip_api_update_ci';
$route['api/cart/multi_location_update/(:any)'] = 'Api/Cart/cart_multi_location_api_update_ci';
//Cart Api


//Appointment Booking History
$route['api/appointment_booking_history/booking_history/(:any)'] = 'Api/user/BookingHistory/booking_history_ci';
$route['api/visit_history/appoinment'] = 'Api/user/BookingHistory/appointment_visit_history_ci';
$route['api/booking_history/doc_booking_update/(:any)'] = 'Api/user/BookingHistory/doctor_booking_update_api_ci';
$route['api/booking_history/nur_booking_update/(:any)'] = 'Api/user/BookingHistory/nurse_booking_update_api_ci';
$route['api/booking_history/lab_booking_update/(:any)'] = 'Api/user/BookingHistory/lab_booking_update_api_ci';
$route['api/booking_history/ambulance_booking_update/(:any)'] = 'Api/user/BookingHistory/ambulance_booking_update_api_ci';
$route['api/booking_history/pharmacy_booking_update/(:any)'] = 'Api/user/BookingHistory/pharmacy_booking_update_api_ci';
$route['api/cancle/appoinment'] = 'Api/user/BookingHistory/cancle_appointment_ci';
$route['api/invoice/appoinment'] = 'Api/user/BookingHistory/invoice_appointment_ci';
//Appointment Booking History



//Payment Integration
$route['api/appointment_booking_history/booking_history/(:any)'] = 'Api/user/BookingHistory/booking_history_ci';
$route['api/cart/getPaymentToken'] = 'Api/Cart/getPaymentToken';
$route['api/cart/setPaymentResponse'] = 'Api/Cart/setPaymentResponse';
//

//Payment Pay
$route['api/payment/additional_payment_pay/(:any)'] = 'Api/user/AdditionalPaymentPay/payment_pay_api_ci';
$route['api/additional_payment_pay/getAddditionalPaymentToken'] = 'Api/user/AdditionalPaymentPay/getAdditionalPaymentToken';
$route['api/additional_payment_pay/setAdditionalPaymentResponse'] = 'Api/user/AdditionalPaymentPay/setAdditionalPaymentResponse';


//Payment Pay
$route['api/get_payment_pending/getPaymentPendingToken'] = 'Api/user/PaymentPending/getPaymentPendingToken';
$route['api/set_payment_pending/setPaymentPendingResponse'] = 'Api/user/PaymentPending/setPaymentPendingResponse';

//
//Member
// $route['api/member_data'] = 'Api/user/Members/member_data';
// $route['api/member_data_insert'] = 'Api/user/Members/member_data_insert';
// $route['api/member_data_update'] = 'Api/user/Members/member_data_update';

//$route['employee'] = 'Api/Employee/index_get';

//$route['api/authentication/registration'] = 'api/authentication/registration';
// $route['api/authentication/user/(:num)(\.)([a-zA-Z0-9_-]+)(.*)'] = 'api/authentication/user/id/$1/format/$3$4';


//API ROUTE

//$route['default_controller'] = 'Login';
$route['default_controller'] = 'user/Login';


$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


//User Route Structure
//$route['userProfile/(:any)'] = 'user/Profile';

$route['signUp'] = 'user/Login/signUp';
$route['forgotPin'] = 'user/Login/forgotPin';
$route['ForgotPassword'] = 'user/Login/ForgotPassword';
$route['userSignup'] = 'user/Login/userSignup';
$route['dashboard'] = 'user/Login/userLogin';


$route['userdashboard'] = 'user/Dashboard';
$route['todayUserAppointment'] = 'user/Dashboard/todayUserAppointment';
$route['userProfile/(:any)'] = 'user/UserProfile';
$route['userProfile'] = 'user/UserProfile';
$route['userresetPassword'] = 'user/UserProfile/changePassword';
$route['userupdateMyProfile'] = 'user/UserProfile/updateMyProfile';

$route['checkSignupEmailId'] = 'AjaxValidation/check_signup_email_id';

$route['UserLogout'] = 'user/Login/userLogout';



//Member
// $route['userMember'] = 'user/Member';
// $route['addMember'] = 'user/Member/insertMember';
// $route['updateMember'] = 'user/Member/updateMember';
// $route['deleteMember'] = 'user/Member/deleteMember';


$route['userMember'] = 'user/Member';
$route['addMember'] = 'user/Member/addMember';
$route['insertMember'] = 'user/Member/insertMember';
$route['editMember'] = 'user/Member/editMember';
$route['updateMember'] = 'user/Member/updateMember';
$route['deleteMember'] = 'user/Member/deleteMember';


$route['userAddress'] = 'user/Address';
$route['addAddress'] = 'user/Address/addAddress';
$route['insertAddress'] = 'user/Address/insertAddress';
$route['editAddress'] = 'user/Address/editAddress';
$route['updateAddress'] = 'user/Address/updateAddress';
$route['deleteAddress'] = 'user/Address/deleteAddress';
//Member


//Manage Appointment
$route['AppointmentList'] = 'user/AppointmentList';

// $route['DoctorAppointmentList'] = 'user/AppointmentList/DoctorAppointmentList';
$route['addDoctorAppointment'] = 'user/AppointmentList/addDoctorAppointment';
$route['insertdoctorAppointment'] = 'user/AppointmentList/insertDoctorAppointment';

// $route['NurseAppointmentList'] = 'user/AppointmentList/NurseAppointmentList';
$route['addNurseAppointment'] = 'user/AppointmentList/addNurseAppointment';
$route['insertnurseAppointment'] = 'user/AppointmentList/insertNurseAppointment';

// $route['AmbulanceAppointmentList'] = 'user/AppointmentList/AmbulanceAppointmentList';
$route['addAmbulanceAppointment'] = 'user/AppointmentList/addAmbulanceAppointment';
$route['insertambulanceAppointment'] = 'user/AppointmentList/insertAmbulanceAppointment';

// $route['LabAppointmentList'] = 'user/AppointmentList/LabAppointmentList';
$route['addLabAppointment'] = 'user/AppointmentList/addLabAppointment';
$route['insertlabAppointment'] = 'user/AppointmentList/insertLabAppointment';

// $route['PharmacyAppointmentList'] = 'user/AppointmentList/PharmacyAppointmentList';
$route['addPharmacyAppointment'] = 'user/AppointmentList/addPharmacyAppointment';
$route['insertpharmacyAppointment'] = 'user/AppointmentList/insertPharmacyAppointment';


//$route['adminAddDoctorAppointment'] = 'user/AppointmentList/addDoctorAppointment';
//$route['insertDoctorAppointment'] = 'user/AppointmentList/insertDoctorAppointment';

$route['userCart'] = 'user/Cart';
$route['addCart'] = 'user/Cart/addDoctorCartDetails';
$route['editDoctorCart'] = 'user/Cart/editCartDetails';
$route['updateDoctorCart'] = 'user/Cart/updateDoctorCart';




$route['addNurseCart'] = 'user/Cart/addNurseCartDetails';
$route['editNurseCart'] = 'user/Cart/editNurseCartDetails';
$route['updateNurseCart'] = 'user/Cart/updateNurseCart';


$route['addLabCart'] = 'user/Cart/addLabCartDetails';
$route['editLabCart'] = 'user/Cart/editLabCartDetails';
$route['updateLabCart'] = 'user/Cart/updateLabCart';


$route['addPharmacyCart'] = 'user/Cart/addPharmacyCartDetails';

$route['addAmbulanceCart'] = 'user/Cart/addAmbulanceCartDetails';
$route['editAmbulanceCart'] = 'user/Cart/editAmbulanceCartDetails';
$route['updateAmbulanceCart'] = 'user/Cart/updateAmbulanceCart';

$route['removeCartRecord'] = 'user/Cart/removeCartData';
$route['updateVoucherCode'] ='user/Cart/updateVoucherCode';


$route['memberUser'] ='user/Cart/memberAddressDisplay';



//complain
$route['userComplain'] = 'user/Complain';
$route['addComplain'] = 'user/Complain/addComplain';
$route['insertComplain'] = 'user/Complain/insertComplain';

//complain
//Package
$route['userPackage'] = 'user/Package';
$route['userAddPackage/(:any)'] = 'user/Package/addPackage';
$route['userViewPackage'] = 'user/Package/viewPackage';

$route['addPackageCart'] = 'user/Package/addPackageCart';



$route['userMyPackage'] = 'user/MyPackage';
$route['userViewMyPackage'] = 'user/MyPackage/userViewMyPackage';
$route['updatePackageBook'] = 'user/MyPackage/updatePackageBook';


$route['responsePayment'] = 'user/Payment_by_paytm/payby_paytm';
$route['successPayment'] = 'user/Payment_by_paytm/paytm_response';


$route['userWallet'] = 'user/Wallet';
$route['useraddWallet'] = 'user/Wallet/addWallet';

$route['successRechargePayment'] = 'user/Wallet/paytm_recharge_response';

$route['payment_fail'] = 'user/Dashboard/payment_fail';


//
$route['userAdditionalPayment'] = 'user/AdditionalPayment/addAdditionalPayment';
$route['successAdditionalPayment'] = 'user/AdditionalPayment/paytm_additional_response';



$route['successPaymentPage'] = 'user/SuccessPaymentPage';
$route['FailPaymentPage'] = 'user/SuccessPaymentPage/FailPaymentPage';
//Booking History

$route['BookingHistory'] = 'user/BookingHistory';


$route['editBookDoctorAppointment'] = 'user/BookingHistory/editBookDoctorAppointment';
$route['updateDoctorBooking'] = 'user/BookingHistory/updateDoctorBooking';

$route['editBookNurseAppointment'] = 'user/BookingHistory/editBookNurseAppointment';
$route['updateNurseBooking'] = 'user/BookingHistory/updateNurseBooking';

$route['editBookLabAppointment'] = 'user/BookingHistory/editBookLabAppointment';
$route['updateLabBooking'] = 'user/BookingHistory/updateLabBooking';


$route['editBookPharmacyAppointment'] = 'user/BookingHistory/editBookPharmacyAppointment';
$route['updatePharmacyBooking'] = 'user/BookingHistory/updatePharmacyBooking';

$route['editBookAmbulanceAppointment'] = 'user/BookingHistory/editBookAmbulanceAppointment';
$route['updateAmbulanceBooking'] = 'user/BookingHistory/updateAmbulanceBooking';


$route['allBookingHistory'] = 'user/BookingHistory/allBookingHistory';
$route['viewBookingHistory'] = 'user/BookingHistory/viewBookingHistory';

$route['invoice'] = 'user/BookingHistory/invoice';
$route['cancle'] = 'user/BookingHistory/cancle_appointment';


$route['responsePaymentPay'] = 'user/Payment_pay/payment_pay_paid';
$route['successPaymentPaid'] = 'user/Payment_pay/payment_pay_response';
//$route['addVisitNotes'] = 'user/BookingHistory/addVisitNotes';
//

//Voucher
$route['userVoucher'] = 'user/Voucher';
//Voucher

//Voucher
$route['userTermsCondition'] = 'user/TermsCondition';
//Voucher
//Facebook
//$route['facebook'] = 'user/Auth_oa2/session/facebook';
//gmail
//$route['gmail'] = 'user/Auth_oa2/session/google';
//Payment_by_paytm
//Package
//User Route Structure

//Admin Route Structure


$route['adminProfile/(:any)'] = 'admin/Profile';
$route['admin'] = 'admin/Login';
$route['adminLogin'] = 'admin/Login/userLogin';

$route['adminDashboard'] = 'admin/Dashboard';

$route['adminUserLogout'] = 'admin/Login/userLogout';
$route['adminProfile'] = 'admin/Profile';
$route['resetPassword'] = 'admin/Profile/changePassword';
$route['updateMyProfile'] = 'admin/Profile/updateMyProfile';

$route['forgotPinAdmin'] = 'admin/Login/forgotPin';
$route['ForgotPasswordAdmin'] = 'admin/Login/ForgotPassword';


//City Module start
$route['adminCityList'] = 'admin/City';
$route['addCity'] = 'admin/City/insertCity';
$route['updateCity'] = 'admin/City/updateCity';
$route['deleteCity'] = 'admin/City/deleteCity';
//Holiday Module End

//Holiday Module start
$route['adminHolidayList'] = 'admin/Holidays';
$route['addHoliday'] = 'admin/Holidays/insertHoliday';
$route['updateHoliday'] = 'admin/Holidays/updateHoliday';
$route['deleteHoliday'] = 'admin/Holidays/deleteHoliday';
//Holiday Module End


//Zone Module start
$route['adminZoneList'] = 'admin/Zone';
$route['addZone'] = 'admin/Zone/insertZone';
$route['updateZone'] = 'admin/Zone/updateZone';
$route['deleteZone'] = 'admin/Zone/deleteZone';
//Holiday Module End

//Manage Role Module Start
$route['adminManageRole'] = 'admin/Roles';
$route['addRole'] = 'admin/Roles/insertmanagerole';
$route['updateRole'] = 'admin/Roles/updatemanagerole';
$route['deleteRole'] = 'admin/Roles/deletemanagerole';
//Manage Role Module End


//Manage City Mapping Module Start
$route['adminManageCityMapping'] = 'admin/CityMapping';
$route['addCityMapping'] = 'admin/CityMapping/insertCityMapping';
$route['updateCityMapping'] = 'admin/CityMapping/updateCityMapping';
$route['deleteCityMapping'] = 'admin/CityMapping/deleteCityMapping';
//Manage City Mapping Module End


//Manage Employee Module Start
// $route['adminEmployee'] = 'admin/Employee';
// $route['addEmployee'] = 'admin/Employee/addEmployee';
// $route['updateEmployee'] = 'admin/Employee/updateEmployee';
// $route['deleteEmployee'] = 'admin/Employee/deleteEmployee';



$route['adminEmployee'] = 'admin/Employee';
$route['addEmployee'] = 'admin/Employee/addEmployee';
$route['insertEmployee'] = 'admin/Employee/insertEmployee';
$route['editEmployee'] = 'admin/Employee/editEmployee';
$route['updateEmployee'] = 'admin/Employee/updateEmployee';
$route['deleteEmployee'] = 'admin/Employee/deleteEmployee';
// $route['addManager'] = 'pharmacyEmployees/addManager';
// $route['getManager'] = 'pharmacyEmployees/getManager'; 
//Manage Employee Module End


//Doctor List Type Module start
$route['adminDoctorTypeList'] = 'admin/DoctorType';
$route['addDoctorType'] = 'admin/DoctorType/insertDoctorType';
$route['updateDoctorType'] = 'admin/DoctorType/updateDoctorType';
$route['deleteDoctorType'] = 'admin/DoctorType/deleteDoctorType';

//Manage Fees
$route['adminManageFees'] = 'admin/ManageFees';
$route['addManageFees'] = 'admin/ManageFees/addManageFees';
$route['insertManageFees'] = 'admin/ManageFees/insertManageFees';
$route['editManageFees'] = 'admin/ManageFees/editManageFees';
$route['updateManageFees'] = 'admin/ManageFees/updateManageFees';
$route['deleteManageFees'] = 'admin/ManageFees/deleteManageFees';
$route['serviceSubtype'] = 'admin/ManageFees/serviceSubtype';



//Manage Fees
$route['adminManagePackage'] = 'admin/ManagePackage';
$route['addManagePackage'] = 'admin/ManagePackage/addManagePackage';
$route['insertManagePackage'] = 'admin/ManagePackage/insertManagePackage';
$route['editManagePackage'] = 'admin/ManagePackage/editManagePackage';
$route['updateManagePackage'] = 'admin/ManagePackage/updateManagePackage';
$route['deleteManagePackage'] = 'admin/ManagePackage/deleteManagePackage';

//Manage Team
$route['adminManageTeam'] = 'admin/ManageTeam';
$route['addManageTeam'] = 'admin/ManageTeam/addManageTeam';
$route['insertManageTeam'] = 'admin/ManageTeam/insertManageTeam';
$route['editManageTeam'] = 'admin/ManageTeam/editManageTeam';
$route['updateManageTeam'] = 'admin/ManageTeam/updateManageTeam';
$route['deleteManageTeam'] = 'admin/ManageTeam/deleteManageTeam';


//Manage User
$route['adminManageUser'] = 'admin/ManageUser';
$route['addManageUser'] = 'admin/ManageUser/addManageUser';
$route['insertManageUser'] = 'admin/ManageUser/insertManageUser';
$route['editManageUser'] = 'admin/ManageUser/editManageUser';
$route['updateManageUser'] = 'admin/ManageUser/updateManageUser';
$route['deleteManageUser'] = 'admin/ManageUser/deleteManageUser';
//Manage User

//Manage Appointment
$route['adminAppointmentList'] = 'admin/AppointmentList';

$route['adminAddDoctorAppointment'] = 'admin/AppointmentList/addDoctorAppointment';
$route['insertDoctorAppointment'] = 'admin/AppointmentList/insertDoctorAppointment';
$route['adminEditDoctorAppointment'] = 'admin/AppointmentList/adminEditDoctorAppointment';
$route['updateDoctorAppointment'] = 'admin/AppointmentList/updateDoctorAppointment';


$route['adminAddNurseAppointment'] = 'admin/AppointmentList/addNurseAppointment';
$route['insertNurseAppointment'] = 'admin/AppointmentList/insertNurseAppointment';
$route['adminEditNurseAppointment'] = 'admin/AppointmentList/adminEditNurseAppointment';
$route['updateNurseAppointment'] = 'admin/AppointmentList/updateNurseAppointment';

$route['adminAddAmbulanceAppointment'] = 'admin/AppointmentList/addAmbulanceAppointment';
$route['insertAmbulanceAppointment'] = 'admin/AppointmentList/insertAmbulanceAppointment';
$route['adminEditAmbulanceAppointment'] = 'admin/AppointmentList/adminEditAmbulanceAppointment';
$route['updateAmbulanceAppointment'] = 'admin/AppointmentList/updateAmbulanceAppointment';


$route['adminAddLabAppointment'] = 'admin/AppointmentList/addLabAppointment';
$route['insertLabAppointment'] = 'admin/AppointmentList/insertLabAppointment';
$route['adminEditLabAppointment'] = 'admin/AppointmentList/adminEditLabAppointment';
$route['updateLabAppointment'] = 'admin/AppointmentList/updateLabAppointment';

$route['adminAddPharmacyAppointment'] = 'admin/AppointmentList/addPharmacyAppointment';
$route['insertPharmacyAppointment'] = 'admin/AppointmentList/insertPharmacyAppointment';
$route['adminEditPharmacyAppointment'] = 'admin/AppointmentList/adminEditPharmacyAppointment';
$route['updatePharmacyAppointment'] = 'admin/AppointmentList/updatePharmacyAppointment';


$route['viewAdminBookingHistory'] = 'admin/AppointmentList/viewAdminBookingHistory';

//cancel Appointment
$route['cancle_appoinment'] = 'admin/AppointmentList/cancle_appointment';
$route['invoice_recipt'] = 'admin/AppointmentList/invoice_recipt';
//$route['invoice'] = 'user/BookingHistory/invoice';
//cancel Appointment

$route['addVisitNotes'] = 'admin/AppointmentList/addVisitNotes';
$route['addEcgXrayNotes'] = 'admin/AppointmentList/addEcgXrayNotes';
$route['uploadPrescription'] = 'admin/AppointmentList/uploadPrescription';
$route['uploadLabReport'] = 'admin/AppointmentList/uploadLabReport';
$route['addAdditonalPayment'] = 'admin/AppointmentList/addAdditonalPayment';


//Manage Permission
$route['adminManagePermission'] = 'admin/ManagePermission';
$route['addManagePermission'] = 'admin/ManagePermission/addManagePermission';
$route['insertManagePermission'] = 'admin/ManagePermission/insertManagePermission';
$route['editManagePermission'] = 'admin/ManagePermission/editManagePermission';
$route['updateManagePermission'] = 'admin/ManagePermission/updateManagePermission';
$route['deleteManagePermission'] = 'admin/ManagePermission/deleteManagePermission';
//Manage Permission


//Voucher
$route['adminVoucher'] = 'admin/Voucher';
$route['addVoucher'] = 'admin/Voucher/addVoucher';
$route['insertVoucher'] = 'admin/Voucher/insertVoucher';
$route['editVoucher'] = 'admin/Voucher/editVoucher';
$route['updateVoucher'] = 'admin/Voucher/updateVoucher';
$route['deleteVoucher'] = 'admin/Voucher/deleteVoucher';

//Complain
$route['adminComplain'] = 'admin/Complain';


//packgebook

$route['adminPackageBook'] = 'admin/BookPackage';
$route['editBookPackage'] = 'admin/BookPackage/editBookPackage';
$route['updateBookPackage'] = 'admin/BookPackage/updateBookPackage';
$route['deleteBookPackage'] = 'admin/BookPackage/deleteBookPackage';
$route['voucherSearch'] = 'admin/Voucher/voucherSearch';


//dashboard data
$route['todayAppointment'] = 'admin/Dashboard/todayAppointment';
$route['allAppointment'] = 'admin/AppointmentList/allAppointment';
$route['assingAppointment'] = 'admin/AppointmentList/assingAppointment';



//Pathologist
$route['adminPathologist'] = 'admin/Pathologist';
$route['addPathologist'] = 'admin/Pathologist/addPathologist';
$route['insertPathologist'] = 'admin/Pathologist/insertPathologist';
$route['editPathologist'] = 'admin/Pathologist/editPathologist';
$route['updatePathologist'] = 'admin/Pathologist/updatePathologist';
$route['deletePathologist'] = 'admin/Pathologist/deletePathologist';


//Notification
$route['adminNotification'] = 'admin/Notification';
$route['sendNotification'] = 'admin/Notification/sendNotification';

$route['adminsingleNotification'] = 'admin/SingleNotification';
$route['sendSingleNotification'] = 'admin/SingleNotification/sendSingleNotification';

//
$route['adminTermsCondition'] = 'admin/TermsCondition';

//Report
$route['adminDoctorReport'] = 'admin/DoctorReport';
$route['generateDoctorReport'] = 'admin/DoctorReport/generateDoctorReport';

$route['adminNurseReport'] = 'admin/NurseReport';
$route['generateNurseReport'] = 'admin/NurseReport/generateNurseReport';

$route['adminW3CReport'] = 'admin/W3CReport';
$route['generateW3CReport'] = 'admin/W3CReport/generateW3CReport';

$route['adminLabReport'] = 'admin/LabReport';
$route['generateLabReport'] = 'admin/LabReport/generateLabReport';

$route['adminAmbulanceReport'] = 'admin/AmbulanceReport';
$route['generateAmbulanceReport'] = 'admin/AmbulanceReport/generateAmbulanceReport';


//City Wise appartment
$route['adminCityWiseAppointment'] = 'admin/CityWiseAppointmentList';
$route['citywiseAllAppointment'] = 'admin/CityWiseAppointmentList/citywiseAllAppointment';

//all appartment
$route['adminAllAppointment'] = 'admin/AllAppointmentList';
$route['get_details_appointment'] = 'admin/AllAppointmentList/get_details_appointment';
$route['invoice_recipt_appo'] = 'admin/AllAppointmentList/invoice_recipt_appo';
$route['extra_invoice_delete'] = 'admin/AllAppointmentList/extra_invoice_delete';
$route['extra_invoice_edit'] = 'admin/AllAppointmentList/extra_invoice_edit';
$route['adminupdateAppointment'] = 'admin/AllAppointmentList/adminupdateAppointment';

//purchase package list
$route['adminPackagePurchase'] = 'admin/BookPackage/book_package_list';
$route['adminPackageRecipt'] = 'admin/BookPackage/package_invoice';

//all Patient
$route['adminAllPatient'] = 'admin/AllPatient';
$route['adminEditMember'] = 'admin/AllPatient/editMember';
$route['adminupdateMember'] = 'admin/AllPatient/adminupdateMember';

//Routes Created by Mayur 

// Package book
$route['package_list'] = 'admin/PackageBook';
$route['book_package'] = 'admin/PackageBook/book_package';
$route['insert_package'] = 'admin/PackageBook/insert_package';
$route['package_invoice'] = 'admin/PackageBook/invoice_package';
$route['view_package'] = 'admin/PackageBook/admin_view_package';
$route['update_package'] = 'admin/PackageBook/package_update';

// TeleConsulting
$route['tele_consulting_list'] = 'admin/AppointmentList/tele_consulting_list';
$route['Tele_Consulting_Report'] = 'admin/TeleConsultingReport';
$route['generateTeleCosultingReport'] = 'admin/TeleConsultingReport/generateTeleCosultingReport';
$route['tele_consulting'] = 'admin/TeleConsulting';
$route['assingPackageAppointment'] = 'admin/BookPackage/assingPackageAppointment';

$route['assign_package_list'] = 'admin/AssignPackageList';
$route['invoice_assign']  = 'admin/AssignPackageList/package_invoice_recipt';


//
$route['update_appointment'] =  'admin/PackageBook/update_single_appointment';
$route['edit_book_package'] =   'admin/PackageBook/edit_book_package';
$route['update_book_package'] = 'admin/PackageBook/update_book_package';