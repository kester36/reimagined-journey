## Test app

#### Preparation
- fill .env.local with real data
- run command `composer app:migrate`

#### Start app
- run command `composer app:run`
- The app will be on localhost:8000

#### Checks
run command `composer app:check`. it includes:
- codestyle check (phpcs)
- static analyzer (phpstan)
- unit/specification tests (phpspec)
- _behat tests not done_

#### Tasks progress
1. create form and validate in on both side - undone
2. create API request, filter result and show on table - done
3. create Open and Close prices chart - undone
4. send email - undone
