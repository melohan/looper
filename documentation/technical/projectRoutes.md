# List of routes
---

> Our URLs are defined as follows `/controller/action/:variable`
>
> If a page has two variables passed with GET, there is no strict rules. We just tried to keep it logical.

## Controller: Page

| Path  |  Action  | Method | Description|
|---|---|---|---|
|`/`|index|GET|Home page|
|`/page/error/:code`|error|GET|Used for error page 404 and 500|

## Controller: Exercise

| Path  |  Action  | Method | Description|
|---|---|---|---|
|`/exercise/take`|take|GET|List of answering exercise|
|`/exercise/new`|index|GET|Exercise creation page|
|`/exercise/fulfillments/:id`|fulfillments|GET|Answer page for exercise :id|
|`/exercise/manage`|manage|GET|Management page by exercise status|
|`/exercise/create`|create|POST|Not a page, exercise create request  treatment|
|`/exercise/delete/`|delete|POST|Not a page, exercise delete request treatment|
|`/exercise/update/`|update|POST|Not a page, exercise update request treatment|

## Controller: Questions

| Path  |  Action  | Method | Description|
|---|---|---|---|
|`/question/fields/:id`|fields|GET|Exercise's form for question creation|
|`/question/edit/:id`|edit|GET|Question's form for edition|
|`/question/create`|create|POST|Not a page, question create request treatment|
|`/question/delete`|delete|POST|Not a page, question delete request treatment|
|`/question/update/:id`|update|POST|Not a page, question update request treatment|

## Controller: Answers

| Path  |  Action  | Method | Description|
|---|---|---|---|
|`/answer/question/:id`|question|GET|Page of answers by question id|
|`/answer/user/:userId/exercise/:exerciseId`|user|GET|Page of answers by user and exercise id|
|`/answer/exercise/:id`|exercise|GET|Page of answers by exercise id|
|`/answer/exercise/:exerciseId/edit/:userId`|edit|GET|Answer's edition page by user id|
|`/answer/fulfillments/:exerciseId/`|new|POST|Not a page, answer creation treatment |
|`/answer/exercise/:exerciseId/update/:userId`|update|POST|Not a page, answer update treatment|
