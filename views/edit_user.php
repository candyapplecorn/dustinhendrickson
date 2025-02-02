<?php

Functions::Check_User_Permissions_Redirect('Staff');
$View = Functions::Get_View();
$Connection = new Connection();

switch ($_POST['Mode'])
    {
        case 'Edit':
            $User = new User($_POST['userID']);

            if ($_POST['First_Name']!='' && $_POST['First_Name']!=$User->First_Name){ $User_Config['First_Name'] = Functions::Make_Safe($_POST['First_Name']); }
            if ($_POST['Last_Name']!='' && $_POST['Last_Name']!=$User->Last_Name){ $User_Config['Last_Name'] = Functions::Make_Safe($_POST['Last_Name']); }
            if ($_POST['EMail']!='' && $_POST['EMail']!=$User->EMail){ $User_Config['EMail'] = Functions::Make_Safe($_POST['EMail']); }
            if ($_POST['Permissions']!='' && $_POST['Permissions']!=$User->Permissions){ $User_Config['Permissions'] = Functions::Make_Safe($_POST['Permissions']); }
            if ($_POST['Password']!=''){ $Password = md5(Functions::Make_Safe($_POST['Password'])); $User_Config['Password'] = $Password; }
            if ($_POST['FightBot_Name']!='' && $_POST['FightBot_Name']!=$User->FightBot_Name){ $User_Config['FightBot_Name'] = Functions::Make_Safe($_POST['FightBot_Name']); }
            if ($_POST['Account_Locked']!='' && $_POST['Account_Locked']!=$User->Account_Locked){ $User_Config['Account_Locked'] = Functions::Make_Safe($_POST['Account_Locked']); }

            $User->Edit_User($User_Config);
            break;
        case 'Delete':
            $User = new User($_POST['userID']);
            $User->Delete_User();
            break;
        case 'Search by Username':
            $Connection = new Connection();
            $User_Array = array (':Username'=>$_POST['SearchUsername']);
            $User_Results = $Connection->Custom_Query("SELECT * from users WHERE Username=:Username", $User_Array);
            break;
        case 'Search by First':
            $Connection = new Connection();
            $User_Array = array (':First_Name'=>$_POST['SearchFirstName']);
            $User_Results = $Connection->Custom_Query("SELECT * from users WHERE First_Name=:First_Name", $User_Array);
            break;
        case 'Search by Last':
            $Connection = new Connection();
            $User_Array = array (':Last_Name'=>$_POST['SearchLastName']);
            $User_Results = $Connection->Custom_Query("SELECT * from users WHERE Last_Name=:Last_Name", $User_Array);
            break;
        case 'Edit Selected':
            $Connection = new Connection();
            $User_Array = array (':Username'=>$_POST['SearchList']);
            $User_Results = $Connection->Custom_Query("SELECT * from users WHERE Username=:Username", $User_Array);
            break;
    }
?>

<div class='ContentHeader'>Edit Users</div>
<hr>

<table width='100%' cellpadding='10'>
<tr>
<td width='60%'>
<div class='ContentHeader'>Search by Username</div><hr>

<form action='?view=<?PHP echo $View; ?>' method='post'>
    <table>
        <tr>
            <td>
                <input name='SearchUsername' value=''>
            </td>
            <td>
                <input type='submit' value='Search by Username' name='Mode'>
            </td>
        </tr>
    </table>
</form>


<div class='ContentHeader'>Search by First Name</div><hr>

<form action='?view=<?PHP echo $View; ?>' method='post'>
    <table>
        <tr>
            <td>
                <input name='SearchFirstName' value=''>
            </td>
            <td>
                <input type='submit' value='Search by First' name='Mode'>
            </td>
        </tr>
    </table>
</form>


<div class='ContentHeader'>Search by Last Name</div><hr>

<form action='?view=<?PHP echo $View; ?>' method='post'>
    <table>
        <tr>
            <td>
                <input name='SearchLastName' value=''>
            </td>
            <td>
                <input type='submit' value='Search by Last' name='Mode'>
            </td>
        </tr>
    </table>
</form>
</td>


<td width='40%'>

<form method='post' action='?view=<?PHP echo $View; ?>'>
<select name='SearchList' style='width: 100%;' size='15' required='required'>

<?PHP
        $List_Array = array();
        $List_Results = $Connection->Custom_Query("SELECT * FROM users", $List_Array, true);
        foreach ($List_Results as $Row) {
            echo "<option value='" . $Row['Username'] . "'>" . $Row['Username']. "</option>";
        }
?>

</select><br><br>
<input type='submit' value='Edit Selected' name='Mode'>
</form>

</td>
</tr>
</table>


<?PHP
if ($_POST['Mode'] = 'Search')
{
    if ($User_Results)
    {
?>

    <div class='ContentHeader'>Editing user <?php echo $User_Results['Username']; ?></div><hr>
    
    <div class='BlogWrapper'>
    <form action='?view=edit_user' method='post'>
        <table>
            <tr>
                <td>
                Username:
                </td>
                <td>
                    <input size='50' type='text' value='<?PHP echo $User_Results['Username'];?>' name='Username' disabled>
                </td>
            </tr>
            <tr>
                <td>
                First Name:
                </td>
                <td>
                    <input size='50' type='text' value='<?PHP echo $User_Results['First_Name'];?>' name='First_Name'>
                </td>
            </tr>
            <tr>
                <td>
                Last Name:
                </td>
                <td>
                    <input size='50' type='text' value='<?PHP echo $User_Results['Last_Name'];?>' name='Last_Name'>
                </td>
            </tr>
            <tr>
                <td>
                Password:
                </td>
                <td>
                    <input size='50' type='text' value='' name='Password'>
                </td>
            </tr>
            <tr>
                <td>
                Email:
                </td>
                <td>
                    <input size='50' type='text' value='<?PHP echo $User_Results['EMail'];?>' name='EMail'>
                </td>
            </tr>
            <tr>
                <td>
                FightBot Name:
                </td>
                <td>
                    <input size='50' type='text' value='<?PHP echo  $User_Results['FightBot_Name'];?>' name='FightBot_Name'>
                </td>
            </tr>
            <tr>
                <td>
                Permissions:
                </td>
                <td>
                    <input size='50' type='text' value='<?PHP echo $User_Results['Permissions'];?>' name='Permissions'>
                </td>
            </tr>
            <tr>
                <td>
                Account Locked:
                </td>
                <td>
                    <input size='50' type='text' value='<?PHP echo $User_Results['Account_Locked'];?>' name='Account_Locked'>
                </td>
            </tr>
            <tr>
                <td>
                    <input name='userID' type='hidden' value='<?PHP echo $User_Results['ID'];?>'>
                </td>
            </tr>
            <tr>
                <td>
                    <input size='10' type='submit' value='Edit' name='Mode'>
                    <input size='10' type='submit' style='color:red;' value='Delete' name='Mode'>
                </td>
            </tr>
        </table>
    </form>
    </div>
    <br>
<?php
    } else {
    echo "No users found, please refine your search and try again.";
    }
}
