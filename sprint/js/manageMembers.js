function byProj(projectId)
{
    location.href = createLink('sprint', 'managemembers', "proj=" + projectId);
}