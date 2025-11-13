project/
│
├── app/
│   ├── Controllers/
│   │   ├── Home.php
│   │   └── Auth (Shield built-in)
│   ├── Models/
│   ├── Views/
│   │   ├── layout.php
│   │   └── home.php
│   ├── Filters/
│   └── Config/
│
├── public/
│   ├── assets/
│   │   ├── css/
│   │   │   └── style.css  ← compiled from scss/style.scss
│   │   └── js/
│   │       └── app.js     ← compiled from src/js/app.js
│   └── index.php
│
├── src/
│   ├── scss/
│   │   ├── _variables.scss
│   │   └── style.scss
│   └── js/
│       └── app.js
│
├── package.json
├── webpack.config.js (optional)
└── composer.json
