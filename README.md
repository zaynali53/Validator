# PHP Validator

A Simple PHP Input Validator.

<h2>Usage:</h2>

1. Require the "class.validator.php".
2. Set the rules according to your field names with pipe ```|``` and sub-rules with Colon ```:```
3. Call the method ```validate``` with your input data and rules.
4. When validation fails, use ```show_errors``` method to display error messages.

<h2>Example Code:</h2>

```php
require_once 'class.validator.php';

$v = new Validator;

$rules = [
    'email'         =>  'required|email:zayn.com',
    'password'      =>  'required|min_length:8|max_length:30',
    'environment'   =>  'required|white_list:admin,user,guest',
    'file'          =>  'f_required|f_types:jpg,bmp,png'
];

$v->validate($_POST, $rules);

$v->is_valid ?: $v->show_errors(['id' => 'errors', 'class' => 'errors'], TRUE);

echo "<pre>", print_r($_POST), "</pre>";
```

<h2>Rules:</h2>

```
1. required     -   Checks value as must given.
2. email        -   Checks domain of the email is accepted.
3. min_length   -   Checks minimum length.
4. max_length   -   Checks maximum length.
5. white_list   -   Filter from a given set of values.
6. f_required   -   File is required.
7. f_types      -   File types to be validated.
```
