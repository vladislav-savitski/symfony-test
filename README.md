# Symfony test PULS

During this test, you'll need to develop a minimal listing of vehicles based on the [design on adobe XD]().

You will need to use this github as a starter to match the design.

### Vehicles data

A data fixture is ready to be loaded inside the Vehicles entity.

### Run the project

- Install dependencies: `composer install` + `yarn`
- Run Symfony: `php -S localhost:8000 -t public/` or using the symfony CLI
- Check it on http://localhost:8000 (port may change if already taken)

### Verification

You don't need to deploy your project for verification. You can push it in github or send us through a zip file. What is important for us is that we only need to use `php -S localhost:8000 -t public/` in order to see your work, nothing more.

### Rules and Evaluation
- You're allowed to use any external ressource
- You must use Controllers to send back and forth the filtering from the form (don't do it all in Javascript)
- We advice you to use TailwindCSS for the styling
- We advice you to use TWIG for the front

## Points
### Form
- Filter by brand (always keep the brand list untouched, it should reset if the user the form is the user is choosing a brand)
- Filter by price
- Filter by model
- Filter by energy
- Open/Close filters
- Price slider
### Listing of vehicles
- Display NB of vehicles (for the current query)
- Sort by : Price ASC/DESC
- Pagination
- Display first pic of vehicle (any pic you want if not pics available) and data based on the design.
- Always 12 vehicles per page

## Extra
### Form
- Filter by monthly price
- One checkbox (Zero km equal to <= 150 kilometes)
- Animation when opening / closing a filter
- Responsive
### Listing of vehicles
- Sort by : Brand-Model ASC/DESC
- Animation when hovering a vehicle
- Responsive
