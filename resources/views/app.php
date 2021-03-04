<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>
    <link href="/css/app.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" rel="stylesheet">
</head>

<body class="antialiased">
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-dark">
            <a class="navbar-brand" href="#">Sudan Blocked Sites Checker</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
              <ul class="navbar-nav">
                <li class="nav-item add-website-button">
                  <a class="nav-link" href="#" v-on:click="toggleAdd()">
                      Add Website <i class="fa fa-add"></i>
                  </a>
                </li>
              </ul>
            </div>
        </nav>         
        <div class="main-container">
            <div class="centered-container">

                <div class="main-container-header">
                    <div class="main-container-header-title">
                        <h3>Check Blocked Sites in Sudan </h3>
                    </div>
                </div>

                <website-ad-component v-if="showAddComponent"></website-ad-component>

                <div class="websites-list">
                    <div class="searchbar">
                        <input type="text" placeholder="Search..." v-model="search" style="margin-bottom: 20px"/>
                        <i class="fa fa-search"></i>
                    </div>
                    <ul>
                        <website-component v-for="website of filteredWebsites" v-bind:website="website"></website-component>
                    </ul>
                </div>
            </div>
        </div>

        <footer>
            <div class="text-center p-3">
                Made with <i class="fa fa-heart"></i> by
                <a class="text-dark" href="https://eyadroid.com/"> Eyadroid</a>
            </div>
        </footer>
    </div>
</body>

<script src="/js/app.js"></script>

</html>
