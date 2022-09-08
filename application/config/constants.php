<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code


//Dr At Doorstep
//user
defined('USER_PROFILE')  OR define('USER_PROFILE', 'user/userProfile');
defined('USERHEADER')			   OR define('USERHEADER', 'user/header');
defined('USERFOOTER')			   OR define('USERFOOTER', 'user/footer');
defined('MEMBER')      OR define('MEMBER', 'user/memberList');
defined('ADD_MEMBER')      OR define('ADD_MEMBER', 'user/addMember');
defined('EDIT_MEMBER')      OR define('EDIT_MEMBER', 'user/editMember');

defined('ADDRESS')      OR define('ADDRESS', 'user/addressList');
defined('ADD_ADDRESS')      OR define('ADD_ADDRESS', 'user/addAddress');
defined('EDIT_ADDRESS')      OR define('EDIT_ADDRESS', 'user/editAddress');

defined('COMPLAIN')      OR define('COMPLAIN', 'user/complainList');
defined('ADD_COMPLAIN')      OR define('ADD_COMPLAIN', 'user/addComplain');


defined('BOOKINGHISTORY')      OR define('BOOKINGHISTORY', 'user/bookingHistory');
//defined('ADD_COMPLAIN')      OR define('ADD_COMPLAIN', 'user/addComplain');


//admin

defined('BASE_URL')			   OR define('BASE_URL', 'http://localhost/DADS_Web/');
defined('HEADER')			   OR define('HEADER', 'admin/header');
defined('FOOTER')			   OR define('FOOTER', 'admin/footer');
defined('ADMIN_PROFILE')  OR define('ADMIN_PROFILE', 'admin/adminProfile');
defined('EMPLOYEES')      OR define('EMPLOYEES', 'admin/employeeList');
defined('ADD_EMPLOYEE')      OR define('ADD_EMPLOYEE', 'admin/addEmployee');
defined('EDIT_EMPLOYEE')      OR define('EDIT_EMPLOYEE', 'admin/editEmployee');

defined('FEES')      OR define('FEES', 'admin/ManageFeesList');
defined('ADD_FEES')      OR define('ADD_FEES', 'admin/addManageFees');
defined('EDIT_FEES')      OR define('EDIT_FEES', 'admin/editManageFees');

defined('PACKAGE')      OR define('PACKAGE', 'admin/ManagePackageList');
defined('ADD_PACKAGE')      OR define('ADD_PACKAGE', 'admin/addManagePackage');
defined('EDIT_PACKAGE')      OR define('EDIT_PACKAGE', 'admin/editManagePackage');

defined('TEAM')      OR define('TEAM', 'admin/ManageTeamList');
defined('ADD_TEAM')      OR define('ADD_TEAM', 'admin/addManageTeam');
defined('EDIT_TEAM')      OR define('EDIT_TEAM', 'admin/editManageTeam');

defined('USER_MANAGE')      OR define('USER_MANAGE', 'admin/ManageUserList');
defined('ADD_USER_MANAGE')      OR define('ADD_USER_MANAGE', 'admin/addManageUser');
defined('EDIT_USER_MANAGE')      OR define('EDIT_USER_MANAGE', 'admin/editManageUser');


defined('ROLE_PERMISSION')      OR define('ROLE_PERMISSION', 'admin/managePermissionList');
defined('ADD_ROLE_PERMISSION')      OR define('ADD_ROLE_PERMISSION', 'admin/addManagePermission');
defined('EDIT_ROLE_PERMISSION')      OR define('EDIT_ROLE_PERMISSION', 'admin/editManagePermission');



defined('Voucher')      OR define('VOUCHER', 'admin/VoucherList');
defined('ADD_VOUCHER')      OR define('ADD_VOUCHER', 'admin/addVoucher');
defined('EDIT_VOUCHER')      OR define('EDIT_VOUCHER', 'admin/editVoucher');








defined('ADMINCOMPLAIN')      OR define('ADMINCOMPLAIN', 'admin/complainList');


defined('BOOK_PACKAGE')      OR define('BOOK_PACKAGE', 'admin/manageBookPackage');
defined('EDIT_BOOK_PACKAGE')      OR define('EDIT_BOOK_PACKAGE', 'admin/editBookPackage');


defined('PATHOLOGIST')      OR define('PATHOLOGIST', 'admin/PathologistList');
defined('ADD_PATHOLOGIST')      OR define('ADD_PATHOLOGIST', 'admin/addPathologist');
defined('EDIT_PATHOLOGIST')      OR define('EDIT_PATHOLOGIST', 'admin/editPathologist');

defined('ADD_NOTIFICATION')      OR define('ADD_NOTIFICATION', 'admin/add_notification');
defined('ADD_SINGLE_NOTIFICATION')      OR define('ADD_SINGLE_NOTIFICATION', 'admin/add_single_notification');



