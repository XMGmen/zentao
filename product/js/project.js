function byProduct(productID, projectID)
{
    location.href = createLink('product', 'project', "status=byproduct&project=" + projectID + "&orderBy=" + orderBy + '&productID=' + productID);
}