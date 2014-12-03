<?php
Functions::Check_User_Permissions_Redirect('User');

$User = new User($_SESSION['ID']);
$View = Functions::Get_View();

switch ($_POST['Mode'])
    {
        case 'Save':
            $Items_Per_Page = Functions::Make_Safe($_POST['Items_Per_Page']);
            $Theme =Functions::Make_Safe($_POST['Theme']);
            $Show_Help =Functions::Make_Safe($_POST['Show_Help']);

            $User->Save_Configuration($User->ID,$Items_Per_Page, $Theme, $Show_Help);
            Functions::Refresh_Page_Once();
            break;
    }


    //Build up Items Per Page Drop down boxes
    $Items_Per_Page_Options = array();
    array_push($Items_Per_Page_Options, "1");
    array_push($Items_Per_Page_Options, "2");
    array_push($Items_Per_Page_Options, "3");
    array_push($Items_Per_Page_Options, "4");
    array_push($Items_Per_Page_Options, "5");
    array_push($Items_Per_Page_Options, "6");
    array_push($Items_Per_Page_Options, "7");
    array_push($Items_Per_Page_Options, "8");
    array_push($Items_Per_Page_Options, "9");
    array_push($Items_Per_Page_Options, "10");
    array_push($Items_Per_Page_Options, "20");
    array_push($Items_Per_Page_Options, "30");

    foreach ($Items_Per_Page_Options as $Items_Per_Page_Selection){
        $ItemsPerPage_HTML .= "<option value='{$Items_Per_Page_Selection}'" . (($User->Config_Settings['Items_Per_Page'] == $Items_Per_Page_Selection) ? "selected" : "" ) . ">{$Items_Per_Page_Selection}</option>";
    }
    //===============================================


    //Build up Theme Drop Down Boxes.
    $Theme_Options = array();
    array_push($Theme_Options, "Default");
    array_push($Theme_Options, "Blue");
    array_push($Theme_Options, "Red");
    array_push($Theme_Options, "Orange");
    array_push($Theme_Options, "Pink");

    foreach ($Theme_Options as $Theme_Selection){
        $Theme_HTML .= "<option value='{$Theme_Selection}'" . (($User->Config_Settings['Theme'] == $Theme_Selection) ? "selected" : "" ) . ">{$Theme_Selection}</option>";
    }
    //===============================


    //Build up Show_Help Drop Down Boxes.
    $Show_Help_Options = array();
    array_push($Show_Help_Options, "0");
    array_push($Show_Help_Options, "1");

    foreach ($Show_Help_Options as $Show_Help_Selection){
        $Show_Help_HTML .= "<option value='{$Show_Help_Selection}'" . (($User->Config_Settings['Show_Help'] == $Show_Help_Selection) ? "selected" : "" ) . ">{$Show_Help_Selection}</option>";
    }
    //===============================
?>
<div class='ContentHeader'>Settings</div><hr>

<form action='?view=<?php echo $View; ?>' method='post'>
        <table>
            <tr>
                <td>
                    Items Per Page:
                </td>
                <td>
                    <select name='Items_Per_Page'>
                    <?php echo $ItemsPerPage_HTML; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    Theme:
                </td>
                <td>
                    <select name='Theme'>
                    <?php echo $Theme_HTML; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    Show Help:
                </td>
                <td>
                    <select name='Show_Help'>
                    <?php echo $Show_Help_HTML; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    <input name='userID' type='hidden' value='<?php echo $User->ID; ?>'>
                </td>
            </tr>
        </table>
        <input type='submit' value='Save' name='Mode'>
    </form>
