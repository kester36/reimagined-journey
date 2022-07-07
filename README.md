## Test app

#### Preparation
- fill .env.local with real data
- run command `composer app:migrate`

#### Start app
- run command `composer app:run`
- The app will be on localhost:8000

You can open "Company quotes" page by moving to: `http://localhost:8000/company/{symbol}/quotes?startDate={yyyy-mm-dd}&endDate={yyyy-mm-dd}`
For example: `http://localhost:8000/company/AMRN/quotes?startDate=2021-11-11&endDate=2022-05-11`

#### Code quality and tests
run command `composer app:check`. it includes:
- codestyle check (phpcs)
- static analyzer (phpstan)
- unit/specification tests (phpspec)
- _behat tests not done_

#### Tasks progress
1. create form and validate in on both side - undone
2. create API request, filter result and show on table - done
3. create chart - done
4. send email - undone