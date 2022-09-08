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
$route['api/profile'] = 'Api/user/Profile/profile_api_ci';
//$route['employee'] = 'Api/Employee/index_get';
//$route['employee_put'] = 'Api/Employee/index_put';
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

$route['DoctorAppointmentList'] = 'user/AppointmentList/DoctorAppointmentList';
$route['addDoctorAppointment'] = 'user/AppointmentList/addDoctorAppointment';
$route['insertdoctorAppointment'] = 'user/AppointmentList/insertDoctorAppointment';

$route['NurseAppointmentList'] = 'user/AppointmentList/NurseAppointmentList';
$route['addNurseAppointment'] = 'user/AppointmentList/addNurseAppointment';
$route['insertnurseAppointment'] = 'user/AppointmentList/insertNurseAppointment';

$route['AmbulanceAppointmentList'] = 'user/AppointmentList/AmbulanceAppointmentList';
$route['addAmbulanceAppointment'] = 'user/AppointmentList/addAmbulanceAppointment';
$route['insertambulanceAppointment'] = 'user/AppointmentList/insertAmbulanceAppointment';

$route['LabAppointmentList'] = 'user/AppointmentList/LabAppointmentList';
$route['addLabAppointment'] = 'user/AppointmentList/addLabAppointment';
$route['insertlabAppointment'] = 'user/AppointmentList/insertLabAppointment';

$route['PharmacyAppointmentList'] = 'user/AppointmentList/PharmacyAppointmentList';
$route['addPharmacyAppointment'] = 'user/AppointmentList/addPharmacyAppointment';
$route['insertpharmacyAppointment'] = 'user/AppointmentList/insertPharmacyAppointment';


//$route['adminAddDoctorAppointment'] = 'user/AppointmentList/addDoctorAppointment';
//$route['insertDoctorAppointment'] = 'user/AppointmentList/insertDoctorAppointment';

$route['userCart'] = 'user/Cart';
$route['addCart'] = 'user/Cart/addDoctorCartDetails';
$route['addNurseCart'] = 'user/Cart/addNurseCartDetails';
$route['addLabCart'] = 'user/Cart/addLabCartDetails';
$route['addPharmacyCart'] = 'user/Cart/addPharmacyCartDetails';
$route['addAmbulanceCart'] = 'user/Cart/addAmbulanceCartDetails';
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


$route['adminAddNurseAppointment'] = 'admin/AppointmentList/addNurseAppointment';
$route['insertNurseAppointment'] = 'admin/AppointmentList/insertNurseAppointment';

$route['adminAddAmbulanceAppointment'] = 'admin/AppointmentList/addAmbulanceAppointment';
$route['insertAmbulanceAppointment'] = 'admin/AppointmentList/insertAmbulanceAppointment';

$route['adminAddLabAppointment'] = 'admin/AppointmentList/addLabAppointment';
$route['insertLabAppointment'] = 'admin/AppointmentList/insertLabAppointment';

$route['adminAddPharmacyAppointment'] = 'admin/AppointmentList/addPharmacyAppointment';
$route['insertPharmacyAppointment'] = 'admin/AppointmentList/insertPharmacyAppointment';


//Manage User
$route['adminManagePermission'] = 'admin/ManagePermission';
$route['addManagePermission'] = 'admin/ManagePermission/addManagePermission';
$route['insertManagePermission'] = 'admin/ManagePermission/insertManagePermission';
$route['editManagePermission'] = 'admin/ManagePermission/editManagePermission';
$route['updateManagePermission'] = 'admin/ManagePermission/updateManagePermission';
$route['deleteManagePermission'] = 'admin/ManagePermission/deleteManagePermission';
//Manage User