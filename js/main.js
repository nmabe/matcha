var loginForm = document.getElementById('loginForm');
var regForm = document.getElementById('regForm');
var travelling = document.getElementById('travelling');
var exercising = document.getElementById('exercising');
var theater = document.getElementById('theater');
var dancing = document.getElementById('dancing');
var cooking = document.getElementById('cooking');
var outdoors = document.getElementById('outdoors');
var indoors = document.getElementById('indoors');
var politics = document.getElementById('politics');
var pets = document.getElementById('pets');
var photography = document.getElementById('photography');
var sports = document.getElementById('sports');
var music = document.getElementById('music');
var movies = document.getElementById('movies');
var books = document.getElementById('books');
var games = document.getElementById('games');
var poetry = document.getElementById('poetry');
var genders = document.getElementById('genders');
var addUser = document.getElementById('addUser');
var filterByAge = document.getElementById('filterByAge');
var filterByLocation = document.getElementById('filterByLocation');
var filterByRatings = document.getElementById('filterByRating');
var filterByInterests = document.getElementById('filterByInterests');
var sortByAge = document.getElementById('sortByAge');
var sortByInterests = document.getElementById('sortByInterests');
var sortByLocation = document.getElementById('sortByLocation');
var sortByRating = document.getElementById('sortByRating');

/*var slideIndex = [1,1];
var slideId = ["myslide1","myslide2"];

showSlides(0,1);

function plusDivs(no, n){
    showSlides(no, slideIndex[no] += n);
}

function showSlides(no, n)
{
    x = document.getElementsByClassName(slideId[no]);
    var i;
    if (n < 1){slideIndex[no] = x.length}
    if (n > x.length){slideIndex[no] = 1}
    for (i = 0; i < x.length; i++)
    {
        x[i].style.display = "none";
    }
    x[slideIndex[no]-1].style.display = "block";
}
*/


if (filterByAge)
{
    filterByAge.addEventListener('change', function(e){
        e.preventDefault();
        var  xhr = (XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        var formData = new FormData();
        formData.append('age', filterByAge.value);
        formData.append('id', 11);
        if (xhr)
        {
            xhr.onload = function(){
                if (this.readyState == 4)
                {
                    if (xhr.status == 200)
                    {
                        $('body').html(this.responseText);
                    }
                }else{
                    console.log(this.statusText);
                }
            };

            xhr.onerror = function(){
                console.log(this.statusText);
            };

            xhr.open('POST', 'match.php');
            xhr.send(formData);
        }
    });
}

if (filterByLocation)
{
    filterByLocation.addEventListener('change', function(e){
        e.preventDefault();
        var xhr = (XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        var formData = new FormData();
        formData.append('location', filterByLocation.value);
        formData.append('id', 12);
        if (xhr)
        {
            xhr.onload = function(){
                if (this.readyState == 4)
                {
                    if (xhr.status == 200)
                    {
                        $('#katanga').append('filtered by location ' + filterByLocation.value);
                        $('body').html(this.responseText);
                    }
                }
                else{
                    console.log(this.statusText);
                }
            };

            xhr.onerror = function(){
                console.log(this.statusText);
            };

            xhr.open('POST', 'match.php');
            xhr.send(formData);
        }
    });
}

if (filterByRatings)
{
    filterByRatings.addEventListener('change', function(e){
        e.preventDefault();
        var xhr = (XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        var formData = new FormData();
        formData.append('ratings', filterByRatings.value);
        formData.append('id', 13);
        if (xhr)
        {
            xhr.onload = function(){
                if (this.readyState == 4)
                {
                    if (xhr.status == 200)
                    {
                        $('body').html(this.responseText);
                    }
                }else{
                    console.log(this.statusText);
                }
            };

            xhr.onerror = function(){
                console.log(this.statusText);
            };
            xhr.open('POST', 'match.php');
            xhr.send(formData);
        }
    });
}

if (filterByInterests)
{
    filterByInterests.addEventListener('change', function(e){
        e.preventDefault();
        var xhr = (XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        var formData = new FormData();
        formData.append('interests', filterByInterests.value);
        formData.append('id', 14);
        if (xhr)
        {
            xhr.onload = function()
            {
                if (this.readyState == 4)
                {
                    if (xhr.status == 200)
                    {
                        $('#katanga').append('Filtered By Interests ' + filterByInterests.value);
                        $('body').html(this.responseText);      
                    }
                }else{
                    console.log(this.statusText);
                }
            };

            xhr.onerror = function(){
                console.log(thi.statusText);
            };
            xhr.open('POST', 'match.php');
            xhr.send(formData);
        }
    });
}

if (sortByAge)
{
    sortByAge.addEventListener('change', function(e){
        e.preventDefault();
        var xhr = (XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        var formData = new FormData();
        formData.append('sAge', sortByAge.value);
        formData.append('id', 15);
        if (xhr)
        {
            xhr.onload = function()
            {
                if (xhr.readyState == 4)
                {
                    if (xhr.status == 200)
                    {
                        $('body').html(this.responseText);
                    }
                }else{
                    console.log(this.statusText);
                }
            };
            this.onerror = function(e) {
                console.log(this.statusText);
            };
            xhr.open('POST', 'match.php');
            xhr.send(formData);
        }
    });
}

if (sortByLocation)
{
    sortByLocation.addEventListener('change', function(e){
        e.preventDefault();
        var xhr = (XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        var formData = new FormData();
        formData.append('sLocation', sortByLocation.value);
        formData.append('id', 16);
        if (xhr)
        {
            xhr.onload = function()
            {
                if (xhr.readyState == 4)
                {
                    if (xhr.status == 200)
                    {
                        $('body').html(this.responseText);
                    }
                }else{
                    console.log(this.statusText);
                }
            };

            this.onerror = function(){
                console.log(this.statusText);
            };
            xhr.open('POST', 'match.php');
            xhr.send(formData);
        }
    });
}

if (sortByRating)
{
    sortByRating.addEventListener('change', function(e){
        e.preventDefault();
        var xhr = (XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        var formData = new FormData();
        formData.append('sRating', sortByRating.value);
        formData.append('id', 17);
        if (xhr)
        {
            xhr.onload = function()
            {
                if (xhr.readyState == 4)
                {
                    if (xhr.status == 200)
                    {
                        $('body').html(this.responseText);      
                    }
                    
                }else{
                    console.log(this.statusText);
                }
            };
            this.onerror = function(){
                console.log(this.statusText);
            };
            xhr.open('POST', 'match.php');
            xhr.send(formData);
        }
    });
}

if (sortByInterests)
{
    sortByInterests.addEventListener('change', function(e){
        e.preventDefault();
        var xhr = (XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        var formData = new FormData();
        formData.append('sInterests', filterByInterests.value);
        formData.append('id', 18);
        if (xhr)
        {
            xhr.onload = function()
            {
                if (xhr.readyState == 4)
                {
                    if (xhr.status == 200)
                    {
                        $('body').html(this.responseText);      
                    }
                }else{
                    console.log(this.statusText);
                }
            };

            this.onerror = function(){
                console.log(this.statusText);
            };
            xhr.open('POST', 'match.php');
            xhr.send(formData);
        }
    });
}

if (genders){
    genders.addEventListener('change', function(){
        var uid = document.getElementById('pref').value;
        val = (genders.value == "Male") ? 1 : 0;
        if(val == 0)
        {
            val = (genders.value == "Both") ? 2 : 0;
        }
        var xhr = (XMLHttpRequest) ? new XMLHttpRequest() : new  ActiveXObject('Microsoft.XMLHTTP');
        var formData = new FormData();
        formData.append('sex', 59);
        formData.append("user_id", uid);
        formData.append("gender", val);

        if(xhr)
        {
            xhr.open('POST', 'pref.php', true);
            xhr.onload = function () {
                if(this.status == 200)
                {
                    document.getElementById('katris').append(this.responseText);
                }
            }
        }
        xhr.send(formData);
    });
}

if (travelling){
    travelling.addEventListener('click', function(){
        var interest = "<div class=\"interests\"><p>travelling</p></div>";
        $('div#myInterests').append(interest);
        var uid = document.getElementById('pref').value;
        var xhr = (XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        var formData = new FormData();
        formData.append("user_id", uid);
        formData.append("travelling", 42);

        if (xhr)
        {
            xhr.open('POST', 'pref.php', true);
            xhr.onload = function(){
                if (xhr.status == 200){
                    $('#travelling').hide(1500);
                    document.getElementById('katris').append(this.responseText);
                }
            }
        }
        xhr.send(formData);
    });
}

if (exercising){
    exercising.addEventListener('click', function(){
        var interest = "<div class=\"interests\"><p>exercising</p></div>";
        $('div#myInterests').append(interest);
        var uid = document.getElementById('pref').value;
        var xhr = (XMLHttpRequest) ?  new XMLHttpRequest : new ActiveXObject('Microsoft.XMLHTTP');
        var formData = new FormData();
        formData.append("user_id", uid);
        formData.append("exercising", 43);

        if (xhr)
        {
            xhr.open('POST', 'pref.php', true);
            xhr.onload = function(){
                if (xhr.status == 200){
                    $('#exercising').hide(1500);
                    document.getElementById('katris').append(this.responseText);
                }
            }
        }
        xhr.send(formData);
    });
}

if (theater){
    theater.addEventListener('click', function(){
        var interest = "<div class=\"interests\"><p>theater</p></div>";
        $('div#myInterests').append(interest);
        var uid = document.getElementById('pref').value;
        var xhr = (XMLHttpRequest) ? new XMLHttpRequest : new ActiveXObject('Microsoft.XMLHTTP');
        var formData = new FormData();

        formData.append("user_id", uid);
        formData.append("theater", 44);
        
        if (xhr)
        {
            xhr.open('POST', 'pref.php', true);
            xhr.onload = function(){
                if (this.status == 200)
                {
                    $('#theater').hide(1500);
                    document.getElementById('katris').append(this.responseText);
                }
            }
        }
        xhr.send(formData);
    });
}

if (dancing){
    dancing.addEventListener('click', function(){
        var interest = "<div class=\"interests\"><p>dancing</p></div>";
        $('div#myInterests').append(interest);
        var uid = document.getElementById('pref').value;
        var xhr = (XMLHttpRequest) ? new XMLHttpRequest : new ActiveXObject('Microsoft.XMLHTTP');
        var formData = new FormData();

        formData.append("user_id", uid);
        formData.append("dancing", 45);
        if (xhr)
        {
            xhr.open('POST', 'pref.php', true);
            xhr.onload = function(){
                if (this.status == 200)
                {
                    $('#dancing').hide(1500);
                    document.getElementById('katris').append(this.responseText);
                }
            }
        }
        xhr.send(formData);
    });
}

if (cooking){
    cooking.addEventListener('click', function(){
        var interest = "<div class=\"interests\"><p>cooking</p></div>";
        $('div#myInterests').append(interest);
        var uid = document.getElementById('pref').value;
        var xhr = (XMLHttpRequest) ? new XMLHttpRequest : new ActiveXObject('Microsoft.XMLHTTP');
        var formData = new FormData();

        formData.append("user_id", uid);
        formData.append("cooking", 46);
        if (xhr)
        {
            xhr.open('POST', 'pref.php', true);
            xhr.onload = function(){
                if(this.status == 200)
                {
                    $('#cooking').hide(1500);
                    document.getElementById('katris').append(this.responseText);
                }
            }
        }
        xhr.send(formData);
    });
}

if (outdoors){
    outdoors.addEventListener('click', function(){
        var interest = "<div class=\"interests\"><p>outdoors</p></div>";
        $('div#myInterests').append(interest);
        var uid = document.getElementById('pref').value;
        var xhr = (XMLHttpRequest) ? new XMLHttpRequest : new ActiveXObject('Microsoft.XMLHTTP');
        var formData = new FormData();
        
        formData.append("user_id", uid);
        formData.append("outdoors", 47);
        
        if (xhr)
        {
            xhr.open('POST', 'pref.php', true);
            xhr.onload = function(){
                if (this.status == 200)
                {
                    $('#outdoors').hide(1500);
                    document.getElementById('katris').append(this.responseText);
                }
            }
        }
        xhr.send(formData);
    });
}

if (indoors){
    indoors.addEventListener('click', function(){
        var interest = "<div class=\"interests\"><p>indoors</p></div>";
        $('div#myInterests').append(interest);
        var uid = document.getElementById('pref').value;
        var xhr = (XMLHttpRequest) ? new XMLHttpRequest : new ActiveXObject('Microsoft.XMLHTTP');
        var formData = new FormData();
        
        formData.append("user_id", uid);
        formData.append("indoors", 56);
        if (xhr)
        {
            xhr.open('POST', 'pref.php', true);
            xhr.onload = function(){
                if (this.status == 200)
                {
                    $('#indoors').hide(1500);
                    document.getElementById('katris').append(this.responseText);
                }
            }
        }
        xhr.send(formData);
    });
}

if (politics){
    politics.addEventListener('click', function(){
        var interest = "<div class=\"interests\"><p>politics</p></div>";
        $('div#myInterests').append(interest);
        var uid = document.getElementById('pref').value;
        var xhr = (XMLHttpRequest) ? new XMLHttpRequest : new ActiveXObject('Microsoft.XMLHTTP');
        var formData = new FormData();
        
        formData.append("user_id", uid);
        formData.append("politics", 48);
        
        if (xhr)
        {
            xhr.open('POST', 'pref.php', true);
            xhr.onload = function(){
                if (this.status == 200){
                    $('#politics').hide(1500);
                    document.getElementById('katris').append(this.responseText);
                }
            }
        }
        xhr.send(formData);
    });
}

if (pets){
    pets.addEventListener('click', function(){
        var interest = "<div class=\"interests\"><p>pets</p></div>";
        $('div#myInterests').append(interest);
        var uid = document.getElementById('pref').value;
        var formData = new FormData();
        var xhr = (XMLHttpRequest) ? new XMLHttpRequest : new ActiveXObject('Microsoft.XMLHTTP');
        formData.append("user_id", uid);
        formData.append("pets", 49);
        if (xhr){
            xhr.open('POST', 'pref.php', true);
            xhr.onload = function(){
                if (this.status == 200)
                {
                    $('#pets').hide(1500);
                    document.getElementById('katris').append(this.responseText);
                }
            }
        }
        xhr.send(formData);
    });
}

if (photography){
    photography.addEventListener('click', function(){
        var interest = "<div class=\"interests\"><p>photography</p></div>";
        $('div#myInterests').append(interest);
        var uid = document.getElementById('pref').value;
        var formData = new FormData();
        var xhr = (XMLHttpRequest) ? new XMLHttpRequest : new ActiveXObject('Microsoft.XMLHTTP');
        formData.append("user_id", uid);
        formData.append("photography", 50);
        if(xhr)
        {
            xhr.open('POST', 'pref.php', true);
            xhr.onload = function(){
                if (this.status == 200)
                {
                    $('#photography').hide(1500);
                    document.getElementById('katris').append(this.responseText);
                }
            }
        }
        xhr.send(formData);
    });
}


if (sports){
    sports.addEventListener('click', function(){
        var interest = "<div class=\"interests\"><p>sports</p></div>";
        $('div#myInterests').append(interest);
        var uid = document.getElementById('pref').value;
        var formData = new FormData();
        var xhr = (XMLHttpRequest) ? new XMLHttpRequest : new ActiveXObject('Microsoft.XMLHTTP');
        
        formData.append("user_id", uid);
        formData.append("sports", 51);
        if (xhr)
        {
            xhr.open('POST','pref.php', true);
            xhr.onload = function(){
                if(xhr.status == 200)
                {
                    $('#sports').hide(1500);
                    document.getElementById('katris').append(this.responseText);
                }
            }
        }
        xhr.send(formData);       
    });
}

if (music){
    music.addEventListener('click', function(){
        var interest = "<div class=\"interests\"><p>music</p></div>";
        $('div#myInterests').append(interest);
        var uid = document.getElementById('pref').value;
        var xhr = (XMLHttpRequest) ? new XMLHttpRequest : ActiveXObject('Microsoft.XMLHTTP');
        var formData = new FormData();
        formData.append("user_id", uid);
        formData.append("music", 52);

        if (xhr)
        {
            xhr.open('POST', 'pref.php', true);
            xhr.onload = function(){
                if(this.status == 200)
                {
                    $('#music').hide(1500);
                    document.getElementById('katris').append(this.responseText);
                }
            }
        }
        xhr.send(formData);
    });
}

if (books){
    books.addEventListener('click', function(){
        var interest = "<div class=\"interests\"><p>books</p></div>";
        $('div#myInterests').append(interest);
        var uid = document.getElementById('pref').value;
        var xhr = (XMLHttpRequest) ? new XMLHttpRequest : new ActiveXObject('Microsoft.XMLHTTP');
        var formData = new FormData();
        
        formData.append("user_id", uid);
        formData.append("books", 53);
        
        if (xhr)
        {
            xhr.open('POST', 'pref.php', true);
            xhr.onload = function(){
                if (this.status == 200)
                {
                    $('#books').hide(1500);
                    document.getElementById('katris').append(this.responseText);
                }
            }
        }
        xhr.send(formData);
    });
}

if (movies){
    movies.addEventListener('click', function(){
        var interest = "<div class=\"interests\"><p>movies</p></div>";
        $('div#myInterests').append(interest);
        var uid = document.getElementById('pref').value;
        var xhr = (XMLHttpRequest) ? new XMLHttpRequest : new ActiveXObject('Microsoft.XMLHTTP');
        var formData = new FormData();
        formData.append("user_id", uid);
        formData.append("movies", 54);

        if(xhr)
        {
            xhr.open('POST', 'pref.php', true);
            xhr.onload = function(){
                if(this.status == 200)
                {
                    document.getElementById('katris').append(this.responseText);
                    $('#movies').hide(1500);
                }
            }
        }
        xhr.send(formData);
    });
}

if (games){
    games.addEventListener('click', function(){
        var interest = "<div class=\"interests\"><p>games</p></div>";
        $('div#myInterests').append(interest);
        var uid = document.getElementById('pref').value;
        var xhr = (XMLHttpRequest) ? new XMLHttpRequest : new ActiveXObject('Microsoft.XMLHTTP');
        var formData = new FormData();

        formData.append("user_id", uid);
        formData.append("games", 55);
        if (xhr)
        {
            xhr.open('POST', 'pref.php', true);
            xhr.onload = function(){
                if(this.status == 200)
                {
                    document.getElementById('katris').append(this.responseText);
                    $('#games').hide(1500);
                }
            }
        }
        xhr.send(formData);
    });
}

if (poetry){
    poetry.addEventListener('click', function(){
        var interest = "<div class=\"interests\"><p>poetry</p></div>";
        $('div#myInterests').append(interest);
        var uid = document.getElementById('pref').value;
        var xhr = (XMLHttpRequest) ? new XMLHttpRequest : new ActiveXObject('Microsoft.XMLHTTP');
        var formData = new FormData();

        formData.append("user_id", uid);
        formData.append("poetry", 57);
        if (xhr)
        {
            xhr.open('POST', 'pref.php', true);
            xhr.onload = function(){
                if(this.status == 200)
                {
                    document.getElementById('katris').append(this.responseText);
                    $('#poetry').hide(1500);
                }
            }
        }
        xhr.send(formData);
    });
}

if (loginForm)
{
    loginForm.addEventListener('submit',function(e){
        e.preventDefault();
        var xhr = (XMLHttpRequest) ? new XMLHttpRequest : new ActiveXObject('Microsoft.XMLHttp');

        xhr.open('POST', 'login.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        var params = '';
        params += 'username='+ document.getElementById('username1').value;
        params += '&password='+ document.getElementById('password1').value;
        params += '&token='+ document.getElementById('token').value;

        xhr.onload = function(){
            if (this.status == 200){
                location.reload(true);
                document.getElementById('id02').style.display = 'none';
                document.getElementById('flash').innerHTML = this.responseText;
            }
        }
        xhr.send(params);
    });
}


if (regForm)
{
    regForm.addEventListener('submit',function(e){
        e.preventDefault();
        var xhr = (XMLHttpRequest) ? new XMLHttpRequest : new ActiveXObject('Microsoft.XMLHttp');

        xhr.open('POST', 'register.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        var params = '';
        params += 'username='+ document.getElementById('username').value;
        params += '&fullname='+ document.getElementById('fullname').value;
        params += '&email='+ document.getElementById('email').value;
        params += '&gender='+ document.getElementById('gender').value;
        params += '&dob='+ document.getElementById('dob').value;
        params += '&password='+ document.getElementById('password').value;
        params += '&address='+ document.getElementById('address').value;
        params += '&password_again='+ document.getElementById('password_again').value;
        params += '&city='+ document.getElementById('city').value;
        params += '&token='+ document.getElementById('token').value;

        xhr.onload = function(){
            if (this.status == 200){
                location.reload(true);
                document.getElementById('id01').style.display = 'none';
                document.getElementById('flash').innerHTML = this.responseText;
            }
        }
        xhr.send(params);
    });
}

function on(index)
{
    document.getElementById(index.id).style.display = 'block';
}

function off(index)
{
    document.getElementById(index.id).style.display = 'none';
}

function addMate(index)
{
    var uid = index;
    var alertit = document.getElementsByClassName('alert');
    var xhr = (XMLHttpRequest) ? new XMLHttpRequest : new ActiveXObject('Microsoft.XMLHTTP');
    var formData = new FormData();
    formData.append('request', uid);

    if (xhr)
    {
        xhr.open('POST', 'addMate.php' , true);
        xhr.onload = function(){
            if (this.status == 200)
            {
                for(var i = 0; i < alertit.length; i++)
                {
                    alertit[i].style.display = 'block';
                    location.reload(true);
                }
                addUser.innerHTML = this.responseText;
            }
        };
    }
    xhr.send(formData);
}

function removeMate(id)
{
    var uid = id;
    var alertit = document.getElementsByClassName('alert');
    var xhr = (XMLHttpRequest) ? new XMLHttpRequest : new ActiveXObject('Microsoft.XMLHTTP');
    var formData = new FormData();
    formData.append('request', uid);

    if (xhr)
    {
        xhr.open('POST', 'removeMate.php' , true);
        xhr.onload = function(){
            if (this.status == 200)
            {
                for(var i = 0; i < alertit.length; i++)
                {
                    alertit[i].style.display = 'block';
                }
                addUser.innerHTML = this.responseText;
                location.reload(true);
            }
        };
    }
    xhr.send(formData);
}

function acceptMate(id)
{
    var uid = id;
    var alertit = document.getElementsByClassName('alert');
    var xhr = (XMLHttpRequest) ? new XMLHttpRequest : new ActiveXObject('Microsoft.XMLHTTP');
    var formData = new FormData();
    formData.append('request', uid);

    if (xhr)
    {
        xhr.open('POST', 'acceptMate.php' , true);
        xhr.onload = function(){
            if (this.status == 200)
            {
                for(var i = 0; i < alertit.length; i++)
                {
                    location.reload(true);
                    alertit[i].style.display = 'block';
                }
                addUser.innerHTML = this.responseText;
            }
        };
    }
    xhr.send(formData);
}

function cancelMate(id)
{
    var uid = id;
    var alertit = document.getElementsByClassName('alert');
    var xhr = (XMLHttpRequest) ? new XMLHttpRequest : new ActiveXObject('Microsoft.XMLHTTP');
    var formData = new FormData();
    formData.append('request', uid);

    if (xhr)
    {
        xhr.open('POST', 'cancelMate.php' , true);
        xhr.onload = function(){
            if (this.status == 200)
            {
                for(var i = 0; i < alertit.length; i++)
                {
                    alertit[i].style.display = 'block';
                }
                addUser.innerHTML = this.responseText;
                location.reload(true);
            }
        };
    }
    xhr.send(formData);
}

function goToThisPage(page)
{
    location.assign(page);
}

function addingRange()
{
    var xhr = (XMLHttpRequest) ? new XMLHttpRequest : new ActiveXObject('Microsoft.XMLHTTP');
    var min = document.getElementById('age-min').value;
    var max = document.getElementById('age-max').value;
    var formData = new FormData();
    formData.append('range', 58);
    formData.append('minimum', min);
    formData.append('maximum', max);

    if (xhr)
    {
        xhr.open('POST', 'pref.php', true);
        xhr.onload = function(){
            if (this.status == 200)
            {
                document.getElementById('katris').append(this.responseText);
            }
        };
    }
    xhr.send(formData);
}

function notifDropDown()
{
    document.getElementById('notifis').classList.toggle("show");
}

function thischat(sender, recipient)
{
    var xhr = (XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var formData = new FormData();

    formData.append('sender', sender);
    formData.append('recipient', recipient);
    if (xhr)
    {
        xhr.onload = function(){
            if (this.readyState == 4)
            {
                $('.incoming_msg').html(this.responseText);
                console.log(this.responseText);
            }else{
                console.log("Got This" +  this.statusText);
            }
        };

        this.onerror = function(){
            console.log(this.statusText);
        };
        xhr.open('POST', 'chats.php');
        xhr.send(formData);
    }
}

function notified(id)
{
    var xhr = (XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft:XMLHTTP');
    var formData = new FormData();

    formData.append('id', id);
    if (xhr)
    {
        xhr.open('POST', 'notification.php');
        xhr.onload = function(){
            if (this.readyState == 4)
            {
                if (this.status == 200)
                {
                    document.getElementById('notifis').append(this.responseText);
                    $('#notifbtn_' + id).hide(1500);
                    console.log('notifbtn_' + id);
                }
            }else
            {
                console.log(this.statusText);
            }
        }
        xhr.send(formData);
    }
}
