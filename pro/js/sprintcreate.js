function setCopyProject(projectID)
{
    location.href = createLink('pro', 'sprintcreate', 'projectID=0&copyProjectID=' + projectID);
}

$(function()
{
    $('#cpmBtn').click(function(){$('#copyProjectModal').modal('show')});
    $('#copyProjects a').click(function(){setCopyProject($(this).data('id')); $('#copyProjectModal').modal('hide')});
});
