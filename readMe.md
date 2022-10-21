Micro blog website done in php mvc

Features of this mvc framework are as follows;
* Routing
-> Create a route file (simple php file) in routes directory
-> Routes are defined as { $app->router->get("/",[ControllerClass::class, "methodName"]) }
    -> $app is an application instance
    -> we can also throw a closure as a second argument to the get method

* Controllers
-> Controller needs to extend base controller class
    -> Controllers has validation features available through ( $this->validate(["attributeName" => ["validationRuleName"]]); ) which will return bool, on fail case it'll set errors on this->errors array as an associative array
    -> validation rule "unique" depends on model for verifing if the data already exists in database so, to use rule "unique" you must define the related model in the controller from where the validation is called
    -> middlewares and templating feature is also implemented in controllers
    -> default layout for templation system will be "layouts/main". Define custom from your controller constructor as ( $this->layout = "layout/custom" )

* Views
-> Views are available in controllers as ( $this->render(string $viewFileName, array $params = ["key" => "value"]) )
    -> $params accepts only arrays/ define keys if you want to access by that key in the actual view file
    -> this if take the define layout or default if not
-> You can also render just the view (without $this->layout) through ( $this->renderView(string $view, array $params = []) )

* Models
-> Extend DBModel class for your custom models as the database logic are defined there
-> You can load data on your model properties through $this->loadData(array $data), this method will return bool
-> Define table name throught function tableName(){ return "tablename"; }
-> You should also define properties on attributes(){ return ["attributename"]; }

