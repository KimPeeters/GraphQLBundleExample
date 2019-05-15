# Install

Clone and run `composer install`

# Run

Run it with `php -S 0.0.0.0:3000 public/index.php`

# Usage

- `curl --data "{\"query\": \"query { getPerson(id:1) { id, name } }\" }" http://localhost:3000/`
- `curl --data "{\"query\": \"query { searchPerson(search: \\\"jon\\\") { id, name, titles { id, name } } }\" }" http://10.0.254.1:3000/`
- `curl --data "{\"query\": \"query { getAllPersons { name, titles { name } } }\" }" http://localhost:3000/`

# GraphiQL

See `http://localhost:3000/graphiql`
