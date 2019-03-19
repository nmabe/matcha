<?php
    require_once 'core/init.php';
    
    if (Input::exists())
    {
        $i = 0;
        $user = new User(Input::get('user_id'));
        $uid = $user->data()->id;
        $pref = new Update($uid);
        if ($user){
            if(Input::get('travelling') == ord('*'))
            {
                $i = 1;
                $pref->interest($uid, 'travelling');
                echo'<p>You Like travelling !!!</p>';
            }
            
            if (Input::get('exercising') ==  ord('+'))
            {
                $i = 1;
                $pref->interest($uid, 'exercising');
                echo'<p>You Like exercising and working out!!!</p>';
            }
            
            if (Input::get('theater') ==  ord(','))
            {
                $i = 1;
                $pref->interest($uid, 'theater');
                echo'<p>You Like theater plays !!!</p>';
            }
            
            if (Input::get('dancing') ==  ord('-'))
            {
                $i = 1;
                $pref->interest($uid, 'dancing');
                echo'<p>You Like dancing, cha cha cha... !!!</p>';
            }
            
            if (Input::get('cooking') ==  ord('.'))
            {
                $i = 1;
                $pref->interest($uid, 'cooking');
                echo'<p>You Like cooking, a person\'s got to eat right!!!</p>';
            }

            if (Input::get('outdoors') ==  ord('/'))
            {
                $i = 1;
                $pref->interest($uid, 'outdoors');
                echo'<p>You Like outdoors, mmmh the smell of nature...!!!</p>';
            }

            if (Input::get('politics') ==  ord('0'))
            {
                $i = 1;
                $pref->interest($uid, 'politics');
                echo'<p>You Like politics, Its all on the news !!!</p>';
            }

            if (Input::get('pets') ==  ord('1'))
            {
                $i = 1;
                $pref->interest($uid, 'pets');
                echo'<p>You Like pets, Dogs, Cats, Hamster, Mouse they so adorable !!!</p>';
            }
            
            if (Input::get('photography') ==  ord('2'))
            {
                $i = 1;
                $pref->interest($uid, 'photogray');
                echo'<p>You Like photography, pictures don\'t lie!!!</p>';
            }

            if (Input::get('sports') ==  ord('3'))
            {
                $i = 1;
                $pref->interest($uid, 'sports');
                echo'<p>You Like sports, soccer, rugby, tennis, judo ...!!!</p>';
            }

            if (Input::get('music') == ord('4'))
            {
                $i = 1;
                $pref->interest($uid, 'music');
                echo'<p>You Like music, R&B, KWAITO, HIPHOP, POP, DANCE !!!</p>';
            }

            if (Input::get('books') == ord('5'))
            {
                $i = 1;
                $pref->interest($uid, 'books');
                echo'<p>You Like books, a reading nation is a winning nation</p>';
            }

            if (Input::get('movies') == ord('6'))
            {
                $i = 1;
                $pref->interest($uid, 'movies');
                echo'<p>You Like movies, Light, Camera, Action... !!!</p>';
            }

            if (Input::get('games') == ord('7'))
            {
                $i = 1;
                $pref->interest($uid, 'games');
                echo'<p>You Like games, EA its in a game !!!</p>';
            }

            if (Input::get('indoors') == ord('8'))
            {
                $i = 1;
                $pref->interest($uid, 'indoors');
                echo'<p>You Like indoors, in my zone!!!</p>';
            }

            if (Input::get('poetry') == ord('9'))
            {
                $i = 1;
                $pref->interest($uid, 'poetry');
                echo'<p>You Like poetry, rythm and reason !!!</p>';
            }

            if (Input::get('range') == ord(':'))
            {
                $i = 1;
                $min  = Input::get('minimum');
                $max  = Input::get('maximum');

                if ($pref->addRange($min, $max)){
                    echo("Range Added");
                }else
                {
                    echo("Range Added");
                }
            }

            if (Input::get('sex') == ord(';'))
            {
                if (Input::get('gender') == 0 || Input::get('gender') == 1 || Input::get('gender') == 2 && (Input::get('range') != ord(':')))
                {
                    $i = 1;
                    $pref->interest($uid, 'gender', Input::get('gender'));
                    echo'<p>Your Gender Preferences Has bee updated !!!</p>';
                }
            }

            if (!$i)
                echo "<p>Your Input Not found: input: " . Input::get('travelling') . "<br> Check againts: " . ord('*') ."<br></p>";
            
        }
        else{
            echo "Your account Not found<br>";
        }
    }
        
?>