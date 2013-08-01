<h3>Create a new project: </h3>
<form action="insert.php" method="post">

    <label for="title">Title: </label><input type="text" name="title" /><br />
    <label for="title">Project ID: </label><input type="text" name="project_id" /><br />
    <label for="description">Description: </label><br />
    <textarea name="description"></textarea><br />
    <label for="budget">Hours Budget: </label><input type="text" name="budget" /><br />
    <label for="overage">All over budget? </label><input type="checkbox" name="overage" /><br /><br />
    <input type="submit" name="submit" value="Create" />
</form>