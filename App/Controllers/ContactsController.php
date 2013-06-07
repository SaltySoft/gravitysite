<?php
/**
 * Copyright (C) 2013 Antoine Jackson
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of
 * this software and associated documentation files (the "Software"), to deal in
 * the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is furnished
 * to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
 * OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
 * IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM,
 * DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR
 * OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE
 * OR OTHER DEALINGS IN THE SOFTWARE.
 */

class ContactsController extends Controller
{
    function create($params = array())
    {
        $contact = new Contact();
        $contact->setEmail($_POST["email"]);
        $this->render = false;
        header("Content-type: application/json");
        $regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';



        if ($_POST["token"] == $_SESSION["token"] && preg_match($regex, $_POST["email"]))
        {
            if (count(Contact::where(array("email" => $_POST["email"]))) <= 0)
            {
                $contact->save();
                echo json_encode(array("status" => "success", "message" => "Thank you, we'll tell you when it's done :)"));
            }
            else
            {
                echo json_encode(array("status" => "error", "message" => "Sorry, you can only subscribe once."));
            }

        } else {
            echo json_encode(array("status" => "error", "message" => "Sorry there was a problem."));
        }

    }
}
