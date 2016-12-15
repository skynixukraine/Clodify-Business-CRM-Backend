"use strict";

/* jshint ignore:start */



/* jshint ignore:end */

define('ecommerce-custom-solutions/app', ['exports', 'ember', 'ecommerce-custom-solutions/resolver', 'ember-load-initializers', 'ecommerce-custom-solutions/config/environment'], function (exports, _ember, _ecommerceCustomSolutionsResolver, _emberLoadInitializers, _ecommerceCustomSolutionsConfigEnvironment) {

  var App = undefined;

  _ember['default'].MODEL_FACTORY_INJECTIONS = true;

  App = _ember['default'].Application.extend({
    modulePrefix: _ecommerceCustomSolutionsConfigEnvironment['default'].modulePrefix,
    podModulePrefix: _ecommerceCustomSolutionsConfigEnvironment['default'].podModulePrefix,
    Resolver: _ecommerceCustomSolutionsResolver['default']
  });

  (0, _emberLoadInitializers['default'])(App, _ecommerceCustomSolutionsConfigEnvironment['default'].modulePrefix);

  exports['default'] = App;
});
define('ecommerce-custom-solutions/components/header-component', ['exports', 'ember'], function (exports, _ember) {
  exports['default'] = _ember['default'].Component.extend({
    classNames: ['header-component'],

    didRender: function didRender() {

      // let element = Ember.$(this.element);

      _ember['default'].$(document).scroll(function () {
        var scrollY = _ember['default'].$(window).scrollTop();

        if (scrollY > 100) {
          _ember['default'].$(".header-component").addClass("header-component_height");
          _ember['default'].$(".nav-menu__title").addClass("nav-menu__title_color");
          _ember['default'].$(".link-content__title").addClass("link-content__title_opacity");
          _ember['default'].$(".nav-social__pic:eq(0)").attr('src', '/assets/img/home-page/section-1/fb-active.png');
          _ember['default'].$(".nav-social__pic:eq(1)").attr('src', '/assets/img/home-page/section-1/Twitter-active.png');
          _ember['default'].$(".nav-social__pic:eq(2)").attr('src', '/assets/img/home-page/section-1/in-active.png');
          _ember['default'].$(".nav-social__pic:eq(3)").attr('src', '/assets/img/home-page/section-1/instagram-active.png');
        } else {

          _ember['default'].$(".header-component").removeClass("header-component_height");
          _ember['default'].$(".nav-menu__title").removeClass("nav-menu__title_color");
          _ember['default'].$(".link-content__title").removeClass("link-content__title_opacity");
          _ember['default'].$(".nav-social__pic:eq(0)").attr('src', '/assets/img/home-page/section-1/fb.png');
          _ember['default'].$(".nav-social__pic:eq(1)").attr('src', '/assets/img/home-page/section-1/twitter.png');
          _ember['default'].$(".nav-social__pic:eq(2)").attr('src', '/assets/img/home-page/section-1/linkedin.png');
          _ember['default'].$(".nav-social__pic:eq(3)").attr('src', '/assets/img/home-page/section-1/instagram.png');
        }
      });
    }
  });
});
define('ecommerce-custom-solutions/components/nav-component', ['exports', 'ember'], function (exports, _ember) {
  exports['default'] = _ember['default'].Component.extend({
    classNames: ['nav-component']
  });
});
define('ecommerce-custom-solutions/components/socials-component', ['exports', 'ember'], function (exports, _ember) {
  exports['default'] = _ember['default'].Component.extend({
    classNames: ['socials-component']
  });
});
define('ecommerce-custom-solutions/controllers/application', ['exports', 'ember'], function (exports, _ember) {

  var routes = [{
    link: 'index',
    title: 'Services'
  }, {
    link: 'people',
    title: 'People'
  }, {
    link: 'blog',
    title: 'Blog'
  }, {
    link: 'contacts',
    title: 'Contacts'
  }];

  var socials = [{
    img: '/assets/img/home-page/section-1/fb.png',
    link: 'https://www.facebook.com/skynix.solutions/'
  }, {
    img: '/assets/img/home-page/section-1/twitter.png',
    link: 'https://twitter.com/skynixukraine'
  }, {
    img: '/assets/img/home-page/section-1/linkedin.png',
    link: 'https://www.linkedin.com/company/skynix'
  }, {
    img: '/assets/img/home-page/section-1/Instagram.png',
    link: 'https://www.instagram.com/skynixukraine/'
  }];

  exports['default'] = _ember['default'].Controller.extend({
    model: {
      routes: routes,
      socials: socials
    }
  });
});
define('ecommerce-custom-solutions/helpers/app-version', ['exports', 'ember', 'ecommerce-custom-solutions/config/environment'], function (exports, _ember, _ecommerceCustomSolutionsConfigEnvironment) {
  exports.appVersion = appVersion;
  var version = _ecommerceCustomSolutionsConfigEnvironment['default'].APP.version;

  function appVersion() {
    return version;
  }

  exports['default'] = _ember['default'].Helper.helper(appVersion);
});
define('ecommerce-custom-solutions/helpers/pluralize', ['exports', 'ember-inflector/lib/helpers/pluralize'], function (exports, _emberInflectorLibHelpersPluralize) {
  exports['default'] = _emberInflectorLibHelpersPluralize['default'];
});
define('ecommerce-custom-solutions/helpers/singularize', ['exports', 'ember-inflector/lib/helpers/singularize'], function (exports, _emberInflectorLibHelpersSingularize) {
  exports['default'] = _emberInflectorLibHelpersSingularize['default'];
});
define('ecommerce-custom-solutions/initializers/app-version', ['exports', 'ember-cli-app-version/initializer-factory', 'ecommerce-custom-solutions/config/environment'], function (exports, _emberCliAppVersionInitializerFactory, _ecommerceCustomSolutionsConfigEnvironment) {
  var _config$APP = _ecommerceCustomSolutionsConfigEnvironment['default'].APP;
  var name = _config$APP.name;
  var version = _config$APP.version;
  exports['default'] = {
    name: 'App Version',
    initialize: (0, _emberCliAppVersionInitializerFactory['default'])(name, version)
  };
});
define('ecommerce-custom-solutions/initializers/container-debug-adapter', ['exports', 'ember-resolver/container-debug-adapter'], function (exports, _emberResolverContainerDebugAdapter) {
  exports['default'] = {
    name: 'container-debug-adapter',

    initialize: function initialize() {
      var app = arguments[1] || arguments[0];

      app.register('container-debug-adapter:main', _emberResolverContainerDebugAdapter['default']);
      app.inject('container-debug-adapter:main', 'namespace', 'application:main');
    }
  };
});
define('ecommerce-custom-solutions/initializers/data-adapter', ['exports', 'ember'], function (exports, _ember) {

  /*
    This initializer is here to keep backwards compatibility with code depending
    on the `data-adapter` initializer (before Ember Data was an addon).
  
    Should be removed for Ember Data 3.x
  */

  exports['default'] = {
    name: 'data-adapter',
    before: 'store',
    initialize: _ember['default'].K
  };
});
define('ecommerce-custom-solutions/initializers/ember-data', ['exports', 'ember-data/setup-container', 'ember-data/-private/core'], function (exports, _emberDataSetupContainer, _emberDataPrivateCore) {

  /*
  
    This code initializes Ember-Data onto an Ember application.
  
    If an Ember.js developer defines a subclass of DS.Store on their application,
    as `App.StoreService` (or via a module system that resolves to `service:store`)
    this code will automatically instantiate it and make it available on the
    router.
  
    Additionally, after an application's controllers have been injected, they will
    each have the store made available to them.
  
    For example, imagine an Ember.js application with the following classes:
  
    App.StoreService = DS.Store.extend({
      adapter: 'custom'
    });
  
    App.PostsController = Ember.Controller.extend({
      // ...
    });
  
    When the application is initialized, `App.ApplicationStore` will automatically be
    instantiated, and the instance of `App.PostsController` will have its `store`
    property set to that instance.
  
    Note that this code will only be run if the `ember-application` package is
    loaded. If Ember Data is being used in an environment other than a
    typical application (e.g., node.js where only `ember-runtime` is available),
    this code will be ignored.
  */

  exports['default'] = {
    name: 'ember-data',
    initialize: _emberDataSetupContainer['default']
  };
});
define('ecommerce-custom-solutions/initializers/export-application-global', ['exports', 'ember', 'ecommerce-custom-solutions/config/environment'], function (exports, _ember, _ecommerceCustomSolutionsConfigEnvironment) {
  exports.initialize = initialize;

  function initialize() {
    var application = arguments[1] || arguments[0];
    if (_ecommerceCustomSolutionsConfigEnvironment['default'].exportApplicationGlobal !== false) {
      var theGlobal;
      if (typeof window !== 'undefined') {
        theGlobal = window;
      } else if (typeof global !== 'undefined') {
        theGlobal = global;
      } else if (typeof self !== 'undefined') {
        theGlobal = self;
      } else {
        // no reasonable global, just bail
        return;
      }

      var value = _ecommerceCustomSolutionsConfigEnvironment['default'].exportApplicationGlobal;
      var globalName;

      if (typeof value === 'string') {
        globalName = value;
      } else {
        globalName = _ember['default'].String.classify(_ecommerceCustomSolutionsConfigEnvironment['default'].modulePrefix);
      }

      if (!theGlobal[globalName]) {
        theGlobal[globalName] = application;

        application.reopen({
          willDestroy: function willDestroy() {
            this._super.apply(this, arguments);
            delete theGlobal[globalName];
          }
        });
      }
    }
  }

  exports['default'] = {
    name: 'export-application-global',

    initialize: initialize
  };
});
define('ecommerce-custom-solutions/initializers/injectStore', ['exports', 'ember'], function (exports, _ember) {

  /*
    This initializer is here to keep backwards compatibility with code depending
    on the `injectStore` initializer (before Ember Data was an addon).
  
    Should be removed for Ember Data 3.x
  */

  exports['default'] = {
    name: 'injectStore',
    before: 'store',
    initialize: _ember['default'].K
  };
});
define('ecommerce-custom-solutions/initializers/store', ['exports', 'ember'], function (exports, _ember) {

  /*
    This initializer is here to keep backwards compatibility with code depending
    on the `store` initializer (before Ember Data was an addon).
  
    Should be removed for Ember Data 3.x
  */

  exports['default'] = {
    name: 'store',
    after: 'ember-data',
    initialize: _ember['default'].K
  };
});
define('ecommerce-custom-solutions/initializers/transforms', ['exports', 'ember'], function (exports, _ember) {

  /*
    This initializer is here to keep backwards compatibility with code depending
    on the `transforms` initializer (before Ember Data was an addon).
  
    Should be removed for Ember Data 3.x
  */

  exports['default'] = {
    name: 'transforms',
    before: 'store',
    initialize: _ember['default'].K
  };
});
define("ecommerce-custom-solutions/instance-initializers/ember-data", ["exports", "ember-data/-private/instance-initializers/initialize-store-service"], function (exports, _emberDataPrivateInstanceInitializersInitializeStoreService) {
  exports["default"] = {
    name: "ember-data",
    initialize: _emberDataPrivateInstanceInitializersInitializeStoreService["default"]
  };
});
define('ecommerce-custom-solutions/resolver', ['exports', 'ember-resolver'], function (exports, _emberResolver) {
  exports['default'] = _emberResolver['default'];
});
define('ecommerce-custom-solutions/router', ['exports', 'ember', 'ecommerce-custom-solutions/config/environment'], function (exports, _ember, _ecommerceCustomSolutionsConfigEnvironment) {

  var Router = _ember['default'].Router.extend({
    location: _ecommerceCustomSolutionsConfigEnvironment['default'].locationType,
    rootURL: _ecommerceCustomSolutionsConfigEnvironment['default'].rootURL
  });

  Router.map(function () {
    this.route('contacts');
    this.route('blog');
    this.route('people');
    this.route('services');
  });

  _ember['default'].$.fn.animated = function (inEffect) {
    _ember['default'].$(this).each(function () {
      var ths = _ember['default'].$(this);
      ths.css("opacity", "0").addClass("animated").waypoint(function (dir) {
        if (dir === "down") {
          ths.addClass(inEffect).css("opacity", "1");
        }
      }, {
        offset: "90"
      });
    });
  };

  exports['default'] = Router;
});
define('ecommerce-custom-solutions/routes/blog', ['exports', 'ember'], function (exports, _ember) {
  exports['default'] = _ember['default'].Route.extend({});
});
define('ecommerce-custom-solutions/routes/contacts', ['exports', 'ember'], function (exports, _ember) {
  exports['default'] = _ember['default'].Route.extend({});
});
define('ecommerce-custom-solutions/routes/index', ['exports', 'ember'], function (exports, _ember) {

  var description = 'Skynix Ukraine is a software development company founded by the';
  var slides = [{
    title: '',
    description: '',
    img: ''
  }];

  exports['default'] = _ember['default'].Route.extend({
    model: function model() {
      return {
        description: description,
        slides: slides
      };
    }
  });
});
define('ecommerce-custom-solutions/routes/people', ['exports', 'ember'], function (exports, _ember) {
  exports['default'] = _ember['default'].Route.extend({});
});
define('ecommerce-custom-solutions/routes/services', ['exports', 'ember'], function (exports, _ember) {
  exports['default'] = _ember['default'].Route.extend({});
});
define('ecommerce-custom-solutions/services/ajax', ['exports', 'ember-ajax/services/ajax'], function (exports, _emberAjaxServicesAjax) {
  Object.defineProperty(exports, 'default', {
    enumerable: true,
    get: function get() {
      return _emberAjaxServicesAjax['default'];
    }
  });
});
define("ecommerce-custom-solutions/templates/application", ["exports"], function (exports) {
  exports["default"] = Ember.HTMLBars.template((function () {
    return {
      meta: {
        "revision": "Ember@2.9.1",
        "loc": {
          "source": null,
          "start": {
            "line": 1,
            "column": 0
          },
          "end": {
            "line": 4,
            "column": 6
          }
        },
        "moduleName": "ecommerce-custom-solutions/templates/application.hbs"
      },
      isEmpty: false,
      arity: 0,
      cachedFragment: null,
      hasRendered: false,
      buildFragment: function buildFragment(dom) {
        var el0 = dom.createDocumentFragment();
        var el1 = dom.createElement("div");
        dom.setAttribute(el1, "class", "app");
        var el2 = dom.createTextNode("\n  ");
        dom.appendChild(el1, el2);
        var el2 = dom.createComment("");
        dom.appendChild(el1, el2);
        var el2 = dom.createTextNode("\n  ");
        dom.appendChild(el1, el2);
        var el2 = dom.createComment("");
        dom.appendChild(el1, el2);
        var el2 = dom.createTextNode("\n");
        dom.appendChild(el1, el2);
        dom.appendChild(el0, el1);
        return el0;
      },
      buildRenderNodes: function buildRenderNodes(dom, fragment, contextualElement) {
        var element0 = dom.childAt(fragment, [0]);
        var morphs = new Array(2);
        morphs[0] = dom.createMorphAt(element0, 1, 1);
        morphs[1] = dom.createMorphAt(element0, 3, 3);
        return morphs;
      },
      statements: [["inline", "header-component", [], ["model", ["subexpr", "@mut", [["get", "model", ["loc", [null, [2, 27], [2, 32]]], 0, 0, 0, 0]], [], [], 0, 0]], ["loc", [null, [2, 2], [2, 34]]], 0, 0], ["content", "outlet", ["loc", [null, [3, 2], [3, 12]]], 0, 0, 0, 0]],
      locals: [],
      templates: []
    };
  })());
});
define("ecommerce-custom-solutions/templates/blog", ["exports"], function (exports) {
  exports["default"] = Ember.HTMLBars.template((function () {
    return {
      meta: {
        "revision": "Ember@2.9.1",
        "loc": {
          "source": null,
          "start": {
            "line": 1,
            "column": 0
          },
          "end": {
            "line": 2,
            "column": 0
          }
        },
        "moduleName": "ecommerce-custom-solutions/templates/blog.hbs"
      },
      isEmpty: false,
      arity: 0,
      cachedFragment: null,
      hasRendered: false,
      buildFragment: function buildFragment(dom) {
        var el0 = dom.createDocumentFragment();
        var el1 = dom.createComment("");
        dom.appendChild(el0, el1);
        var el1 = dom.createTextNode("\n");
        dom.appendChild(el0, el1);
        return el0;
      },
      buildRenderNodes: function buildRenderNodes(dom, fragment, contextualElement) {
        var morphs = new Array(1);
        morphs[0] = dom.createMorphAt(fragment, 0, 0, contextualElement);
        dom.insertBoundary(fragment, 0);
        return morphs;
      },
      statements: [["content", "outlet", ["loc", [null, [1, 0], [1, 10]]], 0, 0, 0, 0]],
      locals: [],
      templates: []
    };
  })());
});
define("ecommerce-custom-solutions/templates/components/header-component", ["exports"], function (exports) {
  exports["default"] = Ember.HTMLBars.template((function () {
    var child0 = (function () {
      return {
        meta: {
          "revision": "Ember@2.9.1",
          "loc": {
            "source": null,
            "start": {
              "line": 2,
              "column": 2
            },
            "end": {
              "line": 7,
              "column": 2
            }
          },
          "moduleName": "ecommerce-custom-solutions/templates/components/header-component.hbs"
        },
        isEmpty: false,
        arity: 0,
        cachedFragment: null,
        hasRendered: false,
        buildFragment: function buildFragment(dom) {
          var el0 = dom.createDocumentFragment();
          var el1 = dom.createTextNode("    ");
          dom.appendChild(el0, el1);
          var el1 = dom.createElement("div");
          dom.setAttribute(el1, "class", "link-content_center");
          var el2 = dom.createTextNode("\n      ");
          dom.appendChild(el1, el2);
          var el2 = dom.createElement("img");
          dom.setAttribute(el2, "src", "/assets/img/home-page/section-1/headerlogo.png");
          dom.setAttribute(el2, "alt", "");
          dom.setAttribute(el2, "class", "link-content__pic");
          dom.appendChild(el1, el2);
          var el2 = dom.createTextNode("\n      ");
          dom.appendChild(el1, el2);
          var el2 = dom.createElement("span");
          dom.setAttribute(el2, "class", "link-content__title");
          var el3 = dom.createTextNode("Skynix");
          dom.appendChild(el2, el3);
          dom.appendChild(el1, el2);
          var el2 = dom.createTextNode("\n    ");
          dom.appendChild(el1, el2);
          dom.appendChild(el0, el1);
          var el1 = dom.createTextNode("\n");
          dom.appendChild(el0, el1);
          return el0;
        },
        buildRenderNodes: function buildRenderNodes() {
          return [];
        },
        statements: [],
        locals: [],
        templates: []
      };
    })();
    return {
      meta: {
        "revision": "Ember@2.9.1",
        "loc": {
          "source": null,
          "start": {
            "line": 1,
            "column": 0
          },
          "end": {
            "line": 12,
            "column": 6
          }
        },
        "moduleName": "ecommerce-custom-solutions/templates/components/header-component.hbs"
      },
      isEmpty: false,
      arity: 0,
      cachedFragment: null,
      hasRendered: false,
      buildFragment: function buildFragment(dom) {
        var el0 = dom.createDocumentFragment();
        var el1 = dom.createElement("div");
        dom.setAttribute(el1, "class", "container");
        var el2 = dom.createTextNode("\n");
        dom.appendChild(el1, el2);
        var el2 = dom.createComment("");
        dom.appendChild(el1, el2);
        var el2 = dom.createTextNode("  ");
        dom.appendChild(el1, el2);
        var el2 = dom.createElement("div");
        dom.setAttribute(el2, "class", "navigation");
        var el3 = dom.createTextNode("\n    ");
        dom.appendChild(el2, el3);
        var el3 = dom.createComment("");
        dom.appendChild(el2, el3);
        var el3 = dom.createTextNode("\n    ");
        dom.appendChild(el2, el3);
        var el3 = dom.createComment("");
        dom.appendChild(el2, el3);
        var el3 = dom.createTextNode("\n  ");
        dom.appendChild(el2, el3);
        dom.appendChild(el1, el2);
        var el2 = dom.createTextNode("\n");
        dom.appendChild(el1, el2);
        dom.appendChild(el0, el1);
        return el0;
      },
      buildRenderNodes: function buildRenderNodes(dom, fragment, contextualElement) {
        var element0 = dom.childAt(fragment, [0]);
        var element1 = dom.childAt(element0, [3]);
        var morphs = new Array(3);
        morphs[0] = dom.createMorphAt(element0, 1, 1);
        morphs[1] = dom.createMorphAt(element1, 1, 1);
        morphs[2] = dom.createMorphAt(element1, 3, 3);
        return morphs;
      },
      statements: [["block", "link-to", ["index"], ["class", "logo__link"], 0, null, ["loc", [null, [2, 2], [7, 14]]]], ["inline", "nav-component", [], ["routes", ["subexpr", "@mut", [["get", "model.routes", ["loc", [null, [9, 27], [9, 39]]], 0, 0, 0, 0]], [], [], 0, 0]], ["loc", [null, [9, 4], [9, 41]]], 0, 0], ["inline", "socials-component", [], ["socials", ["subexpr", "@mut", [["get", "model.socials", ["loc", [null, [10, 32], [10, 45]]], 0, 0, 0, 0]], [], [], 0, 0]], ["loc", [null, [10, 4], [10, 47]]], 0, 0]],
      locals: [],
      templates: [child0]
    };
  })());
});
define("ecommerce-custom-solutions/templates/components/nav-component", ["exports"], function (exports) {
  exports["default"] = Ember.HTMLBars.template((function () {
    var child0 = (function () {
      var child0 = (function () {
        return {
          meta: {
            "revision": "Ember@2.9.1",
            "loc": {
              "source": null,
              "start": {
                "line": 3,
                "column": 4
              },
              "end": {
                "line": 5,
                "column": 4
              }
            },
            "moduleName": "ecommerce-custom-solutions/templates/components/nav-component.hbs"
          },
          isEmpty: false,
          arity: 0,
          cachedFragment: null,
          hasRendered: false,
          buildFragment: function buildFragment(dom) {
            var el0 = dom.createDocumentFragment();
            var el1 = dom.createTextNode("      ");
            dom.appendChild(el0, el1);
            var el1 = dom.createElement("div");
            dom.setAttribute(el1, "class", "nav-menu__title");
            var el2 = dom.createComment("");
            dom.appendChild(el1, el2);
            dom.appendChild(el0, el1);
            var el1 = dom.createTextNode("\n");
            dom.appendChild(el0, el1);
            return el0;
          },
          buildRenderNodes: function buildRenderNodes(dom, fragment, contextualElement) {
            var morphs = new Array(1);
            morphs[0] = dom.createMorphAt(dom.childAt(fragment, [1]), 0, 0);
            return morphs;
          },
          statements: [["content", "route.title", ["loc", [null, [4, 35], [4, 50]]], 0, 0, 0, 0]],
          locals: [],
          templates: []
        };
      })();
      return {
        meta: {
          "revision": "Ember@2.9.1",
          "loc": {
            "source": null,
            "start": {
              "line": 2,
              "column": 2
            },
            "end": {
              "line": 6,
              "column": 2
            }
          },
          "moduleName": "ecommerce-custom-solutions/templates/components/nav-component.hbs"
        },
        isEmpty: false,
        arity: 1,
        cachedFragment: null,
        hasRendered: false,
        buildFragment: function buildFragment(dom) {
          var el0 = dom.createDocumentFragment();
          var el1 = dom.createComment("");
          dom.appendChild(el0, el1);
          return el0;
        },
        buildRenderNodes: function buildRenderNodes(dom, fragment, contextualElement) {
          var morphs = new Array(1);
          morphs[0] = dom.createMorphAt(fragment, 0, 0, contextualElement);
          dom.insertBoundary(fragment, 0);
          dom.insertBoundary(fragment, null);
          return morphs;
        },
        statements: [["block", "link-to", [["get", "route.link", ["loc", [null, [3, 15], [3, 25]]], 0, 0, 0, 0]], ["tagName", "li", "class", "nav-menu__item"], 0, null, ["loc", [null, [3, 4], [5, 16]]]]],
        locals: ["route"],
        templates: [child0]
      };
    })();
    return {
      meta: {
        "revision": "Ember@2.9.1",
        "loc": {
          "source": null,
          "start": {
            "line": 1,
            "column": 0
          },
          "end": {
            "line": 8,
            "column": 0
          }
        },
        "moduleName": "ecommerce-custom-solutions/templates/components/nav-component.hbs"
      },
      isEmpty: false,
      arity: 0,
      cachedFragment: null,
      hasRendered: false,
      buildFragment: function buildFragment(dom) {
        var el0 = dom.createDocumentFragment();
        var el1 = dom.createElement("ul");
        dom.setAttribute(el1, "class", "nav-menu__list");
        var el2 = dom.createTextNode("\n");
        dom.appendChild(el1, el2);
        var el2 = dom.createComment("");
        dom.appendChild(el1, el2);
        dom.appendChild(el0, el1);
        var el1 = dom.createTextNode("\n");
        dom.appendChild(el0, el1);
        return el0;
      },
      buildRenderNodes: function buildRenderNodes(dom, fragment, contextualElement) {
        var morphs = new Array(1);
        morphs[0] = dom.createMorphAt(dom.childAt(fragment, [0]), 1, 1);
        return morphs;
      },
      statements: [["block", "each", [["get", "routes", ["loc", [null, [2, 10], [2, 16]]], 0, 0, 0, 0]], [], 0, null, ["loc", [null, [2, 2], [6, 11]]]]],
      locals: [],
      templates: [child0]
    };
  })());
});
define("ecommerce-custom-solutions/templates/components/socials-component", ["exports"], function (exports) {
  exports["default"] = Ember.HTMLBars.template((function () {
    var child0 = (function () {
      return {
        meta: {
          "revision": "Ember@2.9.1",
          "loc": {
            "source": null,
            "start": {
              "line": 2,
              "column": 2
            },
            "end": {
              "line": 8,
              "column": 2
            }
          },
          "moduleName": "ecommerce-custom-solutions/templates/components/socials-component.hbs"
        },
        isEmpty: false,
        arity: 1,
        cachedFragment: null,
        hasRendered: false,
        buildFragment: function buildFragment(dom) {
          var el0 = dom.createDocumentFragment();
          var el1 = dom.createTextNode("    ");
          dom.appendChild(el0, el1);
          var el1 = dom.createElement("li");
          dom.setAttribute(el1, "class", "nav-social__item");
          var el2 = dom.createTextNode("\n      ");
          dom.appendChild(el1, el2);
          var el2 = dom.createElement("a");
          dom.setAttribute(el2, "class", "nav-social__link");
          var el3 = dom.createTextNode("\n        ");
          dom.appendChild(el2, el3);
          var el3 = dom.createElement("img");
          dom.setAttribute(el3, "alt", "");
          dom.setAttribute(el3, "class", "nav-social__pic");
          dom.appendChild(el2, el3);
          var el3 = dom.createTextNode("\n      ");
          dom.appendChild(el2, el3);
          dom.appendChild(el1, el2);
          var el2 = dom.createTextNode("\n    ");
          dom.appendChild(el1, el2);
          dom.appendChild(el0, el1);
          var el1 = dom.createTextNode("\n");
          dom.appendChild(el0, el1);
          return el0;
        },
        buildRenderNodes: function buildRenderNodes(dom, fragment, contextualElement) {
          var element0 = dom.childAt(fragment, [1, 1]);
          var element1 = dom.childAt(element0, [1]);
          var morphs = new Array(2);
          morphs[0] = dom.createAttrMorph(element0, 'href');
          morphs[1] = dom.createAttrMorph(element1, 'src');
          return morphs;
        },
        statements: [["attribute", "href", ["concat", [["get", "social.link", ["loc", [null, [4, 17], [4, 28]]], 0, 0, 0, 0]], 0, 0, 0, 0, 0], 0, 0, 0, 0], ["attribute", "src", ["concat", [["get", "social.img", ["loc", [null, [5, 20], [5, 30]]], 0, 0, 0, 0]], 0, 0, 0, 0, 0], 0, 0, 0, 0]],
        locals: ["social"],
        templates: []
      };
    })();
    return {
      meta: {
        "revision": "Ember@2.9.1",
        "loc": {
          "source": null,
          "start": {
            "line": 1,
            "column": 0
          },
          "end": {
            "line": 9,
            "column": 5
          }
        },
        "moduleName": "ecommerce-custom-solutions/templates/components/socials-component.hbs"
      },
      isEmpty: false,
      arity: 0,
      cachedFragment: null,
      hasRendered: false,
      buildFragment: function buildFragment(dom) {
        var el0 = dom.createDocumentFragment();
        var el1 = dom.createElement("ul");
        dom.setAttribute(el1, "class", "nav-social__list");
        var el2 = dom.createTextNode("\n");
        dom.appendChild(el1, el2);
        var el2 = dom.createComment("");
        dom.appendChild(el1, el2);
        dom.appendChild(el0, el1);
        return el0;
      },
      buildRenderNodes: function buildRenderNodes(dom, fragment, contextualElement) {
        var morphs = new Array(1);
        morphs[0] = dom.createMorphAt(dom.childAt(fragment, [0]), 1, 1);
        return morphs;
      },
      statements: [["block", "each", [["get", "socials", ["loc", [null, [2, 10], [2, 17]]], 0, 0, 0, 0]], [], 0, null, ["loc", [null, [2, 2], [8, 11]]]]],
      locals: [],
      templates: [child0]
    };
  })());
});
define("ecommerce-custom-solutions/templates/contacts", ["exports"], function (exports) {
  exports["default"] = Ember.HTMLBars.template((function () {
    return {
      meta: {
        "revision": "Ember@2.9.1",
        "loc": {
          "source": null,
          "start": {
            "line": 1,
            "column": 0
          },
          "end": {
            "line": 2,
            "column": 0
          }
        },
        "moduleName": "ecommerce-custom-solutions/templates/contacts.hbs"
      },
      isEmpty: false,
      arity: 0,
      cachedFragment: null,
      hasRendered: false,
      buildFragment: function buildFragment(dom) {
        var el0 = dom.createDocumentFragment();
        var el1 = dom.createComment("");
        dom.appendChild(el0, el1);
        var el1 = dom.createTextNode("\n");
        dom.appendChild(el0, el1);
        return el0;
      },
      buildRenderNodes: function buildRenderNodes(dom, fragment, contextualElement) {
        var morphs = new Array(1);
        morphs[0] = dom.createMorphAt(fragment, 0, 0, contextualElement);
        dom.insertBoundary(fragment, 0);
        return morphs;
      },
      statements: [["content", "outlet", ["loc", [null, [1, 0], [1, 10]]], 0, 0, 0, 0]],
      locals: [],
      templates: []
    };
  })());
});
define("ecommerce-custom-solutions/templates/index", ["exports"], function (exports) {
  exports["default"] = Ember.HTMLBars.template((function () {
    return {
      meta: {
        "revision": "Ember@2.9.1",
        "loc": {
          "source": null,
          "start": {
            "line": 1,
            "column": 0
          },
          "end": {
            "line": 3,
            "column": 6
          }
        },
        "moduleName": "ecommerce-custom-solutions/templates/index.hbs"
      },
      isEmpty: false,
      arity: 0,
      cachedFragment: null,
      hasRendered: false,
      buildFragment: function buildFragment(dom) {
        var el0 = dom.createDocumentFragment();
        var el1 = dom.createElement("div");
        dom.setAttribute(el1, "class", "index-bg");
        var el2 = dom.createTextNode("\n\n");
        dom.appendChild(el1, el2);
        dom.appendChild(el0, el1);
        return el0;
      },
      buildRenderNodes: function buildRenderNodes() {
        return [];
      },
      statements: [],
      locals: [],
      templates: []
    };
  })());
});
define("ecommerce-custom-solutions/templates/people", ["exports"], function (exports) {
  exports["default"] = Ember.HTMLBars.template((function () {
    return {
      meta: {
        "revision": "Ember@2.9.1",
        "loc": {
          "source": null,
          "start": {
            "line": 1,
            "column": 0
          },
          "end": {
            "line": 2,
            "column": 0
          }
        },
        "moduleName": "ecommerce-custom-solutions/templates/people.hbs"
      },
      isEmpty: false,
      arity: 0,
      cachedFragment: null,
      hasRendered: false,
      buildFragment: function buildFragment(dom) {
        var el0 = dom.createDocumentFragment();
        var el1 = dom.createComment("");
        dom.appendChild(el0, el1);
        var el1 = dom.createTextNode("\n");
        dom.appendChild(el0, el1);
        return el0;
      },
      buildRenderNodes: function buildRenderNodes(dom, fragment, contextualElement) {
        var morphs = new Array(1);
        morphs[0] = dom.createMorphAt(fragment, 0, 0, contextualElement);
        dom.insertBoundary(fragment, 0);
        return morphs;
      },
      statements: [["content", "outlet", ["loc", [null, [1, 0], [1, 10]]], 0, 0, 0, 0]],
      locals: [],
      templates: []
    };
  })());
});
define("ecommerce-custom-solutions/templates/services", ["exports"], function (exports) {
  exports["default"] = Ember.HTMLBars.template((function () {
    return {
      meta: {
        "revision": "Ember@2.9.1",
        "loc": {
          "source": null,
          "start": {
            "line": 1,
            "column": 0
          },
          "end": {
            "line": 2,
            "column": 0
          }
        },
        "moduleName": "ecommerce-custom-solutions/templates/services.hbs"
      },
      isEmpty: false,
      arity: 0,
      cachedFragment: null,
      hasRendered: false,
      buildFragment: function buildFragment(dom) {
        var el0 = dom.createDocumentFragment();
        var el1 = dom.createComment("");
        dom.appendChild(el0, el1);
        var el1 = dom.createTextNode("\n");
        dom.appendChild(el0, el1);
        return el0;
      },
      buildRenderNodes: function buildRenderNodes(dom, fragment, contextualElement) {
        var morphs = new Array(1);
        morphs[0] = dom.createMorphAt(fragment, 0, 0, contextualElement);
        dom.insertBoundary(fragment, 0);
        return morphs;
      },
      statements: [["content", "outlet", ["loc", [null, [1, 0], [1, 10]]], 0, 0, 0, 0]],
      locals: [],
      templates: []
    };
  })());
});
/* jshint ignore:start */



/* jshint ignore:end */

/* jshint ignore:start */

define('ecommerce-custom-solutions/config/environment', ['ember'], function(Ember) {
  var prefix = 'ecommerce-custom-solutions';
/* jshint ignore:start */

try {
  var metaName = prefix + '/config/environment';
  var rawConfig = document.querySelector('meta[name="' + metaName + '"]').getAttribute('content');
  var config = JSON.parse(unescape(rawConfig));

  var exports = { 'default': config };

  Object.defineProperty(exports, '__esModule', { value: true });

  return exports;
}
catch(err) {
  throw new Error('Could not read config from meta tag with name "' + metaName + '".');
}

/* jshint ignore:end */

});

/* jshint ignore:end */

/* jshint ignore:start */

if (!runningTests) {
  require("ecommerce-custom-solutions/app")["default"].create({"name":"ecommerce-custom-solutions","version":"0.0.0+450ab19f"});
}

/* jshint ignore:end */
//# sourceMappingURL=ecommerce-custom-solutions.map
