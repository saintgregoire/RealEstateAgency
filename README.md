# ![Logo Estatein](assets/icons/icon32.png "Logo Estatein") ESTATEIN - Real Estate Agency</br>(Frontend + Backend project)

The creation of this project carries the idea of ​​​​applying knowledge of **Front** and **Back development**.

>In the past, while working in marketing, I had a lot of experience working with real estate agencies. 
</br>*So the idea for my project did not take long to arrive.*

**This site is a platform for providing clients with up-to-date information and attracting new clients.**

**Using this website, the agency can:**
* Receive a sorted list of leads from forms on the website.
* Receive a list of unprocessed leads and change their status after processing.
* Download a file with a list of all emails received from forms for further use for marketing purposes.
* View and edit the list and characteristics of real estate displayed on the site.
* Add and remove real estate objects to/from the site.
* View, edit, delete and add users to site management.

![Estatein Home Page](assets/docs/images/main.png "Home Page Screen")

**[==> View website]() Coming soon...**

**[==> View Figma](https://www.figma.com/design/mkozkfJX2EGUIFcbl43EuD/Real-Estate-Business-Website?node-id=45-2&t=EVNNFlmQPORgXUVz-1)**

**[==> Learn more about the admin panel](./assets/docs/ADMIN.md)**

**[==> View conceptual model of database](./assets/docs/images/sql_model.png)**

## Summary

* [Philosophy](#philosophy)
* [Licence](#licence)
* [Tools](#tools)
* [Installation](#installation)
* [Versions](#my-versions)

## Philosophy

I tried to adhere to two main principles:

* [BDUF](https://en.wikipedia.org/wiki/Big_design_up_front)
* [SOLID](https://en.wikipedia.org/wiki/SOLID)

## Licence

Was created under the [MIT Licence](./LICENSE)

## Tools

<img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/html5/html5-original.svg" height="20" alt="html5 logo"  /> HTML</br>
<img src="https://skillicons.dev/icons?i=sass" height="20" alt="sass logo"  /> SCSS</br>
<img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/javascript/javascript-original.svg" height="20" alt="javascript logo"  /> JS</br>
<img src="https://www.svgrepo.com/show/374142/twig.svg" height="20" alt="twig logo"  /> Twig</br>
<img src="https://skillicons.dev/icons?i=php" height="20" alt="php logo"  /> PHP</br>
<img src="https://static-00.iconduck.com/assets.00/sql-database-sql-azure-icon-1955x2048-4pmty46t.png" height="20" alt="sql logo"  /> SQL</br>
<img src="https://skillicons.dev/icons?i=mysql" height="20" alt="mysql logo"  /> MySQL


## Installation

To work with this project you will need <img src="https://skillicons.dev/icons?i=git" height="20" alt="git logo"  />**GIT**, <img src="https://upload.wikimedia.org/wikipedia/commons/2/26/Logo-composer-transparent.png" height="20" alt="composer logo"  />**Composer** and <img src="https://skillicons.dev/icons?i=sass" height="20" alt="sass logo"  />**SASS**

 **[==>How to install Git](https://git-scm.com/book/en/v2/Getting-Started-Installing-Git)**

 **[==>How to install Composer](https://getcomposer.org/doc/00-intro.md)**
>
> **[==>How to install SASS](https://sass-lang.com/install/)**
>
> ***OR***
>
>If you use <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/9a/Visual_Studio_Code_1.35_icon.svg/512px-Visual_Studio_Code_1.35_icon.svg.png?20210804221519" height="20" alt="vscode logo"  /> VSCode you can use the plugin "Live Sass Compiler"
>
><img src="./assets/docs/images/sass_comp.png" width="300" alt="Live Sass Compiler" />

### Local installation:

1. On the command line, navigate to the folder where the project will be deployed. Then copy it from <img src="https://skillicons.dev/icons?i=github" height="20" alt="github logo"  />GitHub :

`$ git clone https://github.com/saintgregoire/RealEstateAgency.git`

2. Create a ***.env*** file and add your data there as specified in the ***.env.example*** file

3. Installing dependencies:

**While in the working directory in the terminal command line:**<br/>
* `composer require vlucas/phpdotenv`
* `composer require "twig/twig:^3.0"`
* `composer require --dev symfony/var-dumper`

***In case of adding new PHP files:*** 

`composer dump-autoload` 

>**In my project I connected [Swiper.js](https://swiperjs.com/) and [Bootstrap](https://getbootstrap.com/docs/5.1/getting-started/introduction/) via cdn. If you need to install via npm:**

1. First you need to install **Node.js** <img src="https://skillicons.dev/icons?i=nodejs" height="20" alt="nodejs logo" />

**[==> How to install Node.js.](https://nodejs.org/en/download)**

2. Check if Node.js is installed:

`$ node --version` or `$ node -v`

3. Instruction for Bootstrap <img src="https://skillicons.dev/icons?i=bootstrap" height="20" alt="bootsrap logo"  />:

**[==> Bootstrap](https://getbootstrap.com/docs/5.1/getting-started/download/#npm)**

4. Instructions for Swiper.js <img src="https://swiperjs.com/images/swiper-logo.svg" height="20" alt="swiperjs logo"  />:

**[==> Swiper.js](https://swiperjs.com/get-started)**

## My versions

**My PHP version**

*8.2.18* <img src="https://skillicons.dev/icons?i=php" height="20" alt="php logo"  />

**My Composer version**

*2.7.7* <img src="https://upload.wikimedia.org/wikipedia/commons/2/26/Logo-composer-transparent.png" height="20" alt="composer logo"  />

**My twig version**

*3.0* <img src="https://www.svgrepo.com/show/374142/twig.svg" height="20" alt="twig logo"  />

**My Bootstrap version**

*v5.1.3* <img src="https://skillicons.dev/icons?i=bootstrap" height="20" alt="bootsrap logo"  />

**My Swiper.js version** 

*v11.1.8* <img src="https://swiperjs.com/images/swiper-logo.svg" height="20" alt="swiperjs logo"  />

**My phpdotenv version** 

*5.6* <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTHaNT3Fi8RMNUpPDk-Zddeo2FTvDN3Sye5AA&s" height="20" alt="env logo"  />

**My var-dumper version**

*5.4*

```javascript
"autoload": {
        "classmap": [
            "controllers/",
            "managers/",
            "models/",
            "services/"
        ]
    },
```

## Contact me

[<img src="https://skillicons.dev/icons?i=linkedin" height="40" alt="linkedin logo"  />](https://www.linkedin.com/in/maksym-voznichka/)
[<img src="https://skillicons.dev/icons?i=gmail" height="40" alt="gmail logo"  />](mailto:maksym.voznicka@gmail.com)
