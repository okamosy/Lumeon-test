#### Question
Please answer the following question textually.

The file web/showhospitalpatients.php is intended to retrieve a list of patients for a given hospital and return that in json format. Are there any comments you would like to make? What could be improved about the code ?

#### Response

1. Change this class to be a controller with a route within the application.  This will provide the following:
    1. A clean URL for users (although this can be handled via .htaccess, it's more consistent to do this via Symfony itself).
    1. Ability to use the URL to define an output format so this can easier to extend (i.e. /patients/ID/json, or /patients/ID.xml)
    1. Simplifies the code as Symfony can load the hospital automatically via a @ParamConverter annotation (the patient list can likely also be loaded this way with a bit more logic).
1. Do not use a global reference for the $request variable.  This can now be passed in as a parameter to the controller.
1. There should be better error checking to ensure the hospital and patient list loaded before dumping them into a JSON response.
