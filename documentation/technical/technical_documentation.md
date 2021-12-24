# Technical documentation

## Context (technical)

The project is guaranteed to run locally with a `PHP 8.0.10` server and `MariaDB 10.6.4` SQL Server.

## Data handled by this site

Database design document:

- [MLD](../conception/db/MLD.PNG)
- [MCD](../conception/db/MCD_CHEN.png)

Class diagram (QueryBuilder, Model, DB)

- [UML](../conception/uml/models.PNG)

## Components and Architecture

This site uses an MVC (Model-View-Controller) architecture. It is a mimic of Laravel architecture. Main components:

| Directories  | Component | Description|
|---|---|---|
|`app/controllers`|Controller.php, *|Main controller and sub controllers|
|`app/models`|Model.php, *|Main models and sub models |
|`app/database/`|DB.php|Class allowing CRUD operation and connection to the database|
|`app/database/`|QueryBuilder.php|Queries builder assistant used on this website|
|`routes/`|Route.php|Builds and extracts information from a URL|
|`routes/`|Router.php|Executes routes defined in `public/index.php`|

### Files and directories

|| Directories |Information|
|---|---|---|
|View|`resources/views/`| Contains main layout, it includes all other views.|
|DB Connection|`config/db.php`| Database consts file, it is used in UnitTests and by `app/database/DB.php`|
|Const and paths file|`config/.env.php`|Contains VIEW, SCRIPT and PROJECT_ROOT consts|
|Routes|`public/index.php`|All routes are defined at this location|
|Scripts (JS)|`public/js/main.js`|Buttons with events are managed in this file|

## Interaction between components

1) `public/index.php` is the first page loaded. It is this page that will include the routes and routers and perform the
   processing of an URL.
2) The request sent to the server is interpreted to retrieve the appropriate controller (by Route and Router).
3) The controller calls the layout and the view of the page. Data processing (POST treatment or display in a view) is a
   result of exchange between controllers and templates.

If an URL doesn't exist, the router will redirect to a 404 error page. If the connection to the database is interrupted
or if it failed, the index will redirect to a 500 internal server error.

## Navigation and routes

More details on the current routes [details](../technical/projectRoutes.md)

Currently, and in general, URLs are constructed according to the following logic: `controller/action/variable`
Some more complex URLs are detailed in the routes file.

## Tips

### Tip #1: Post an array

In the answers page of an exercise, we use an array with the following form as the input tag name
`fullfillment[answers_attributes][][field_id]`.

```html
<textarea name="fulfillment[answers_attributes][][value]"></textarea>
```

Its processing is made in AnswerController update() and new() methods. Their treatment is made from AnswerController's
update() and new() methods.

### Tip #2: Id sent in post

Sometimes the current modified/deleted entity id is sent by a hidden input. This is the case with the edit page of
answer

```HTML
<input type="hidden" value="<?= $answer->getQuestion()->getId(); ?>""
name="fulfillment[answers_attributes][][questionId]" />
```

### Tip # 3: Modification of status by JS

When status change (especially in the question creation and manage page), a JS script will make the change request to
the server. The script will retrieve all the `<a> </a>` tags containing a data-method set and add a click event to
request confirmation.

```javascript
  document.querySelectorAll('a[data-method="delete"]').forEach(item => {
    item.addEventListener("click", function () {
        if (!confirm(item.dataset.confirm)) return false;
   ```

### Tip # 4: Use abstract class as enum

Types and statuses have their own abstract class as enum. Their values are fixed according to their id in database. This
implementation choice forces to insert their data at the creation of the database.

This is why they're not considered as data example and they're not in `database/dataExample.sql` file but directly
in `database/dataBase.sql`