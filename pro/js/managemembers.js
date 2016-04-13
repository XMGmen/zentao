function byPro(planID)
{
    location.href = createLink('pro', 'managemembers', "pro=" + planID);
}

function changeGroup(role)
{
    if(role || roleGroup[role])
    {
        $('#group').val(roleGroup[role]); 
    }
    else
    {
        $('#group').val(''); 
    }
}