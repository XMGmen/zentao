$(function()
{
    initBurnChar();

    $('#burnTab').addClass('active');

    $('#interval').change(function()
    {
        location.href = createLink('sprint', 'burn', 'projectID=' + projectID + '&type=' + type + '&interval=' + $(this).val());
    });
})

function byProj(projectId)
{
    location.href = createLink('sprint', 'burn', "proj=" + projectId);
}