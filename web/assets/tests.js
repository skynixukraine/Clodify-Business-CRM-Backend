'use strict';

define('ecommerce-custom-solutions/tests/acceptance/home-test', ['exports', 'qunit', 'ecommerce-custom-solutions/tests/helpers/module-for-acceptance'], function (exports, _qunit, _ecommerceCustomSolutionsTestsHelpersModuleForAcceptance) {

  (0, _ecommerceCustomSolutionsTestsHelpersModuleForAcceptance['default'])('Acceptance | home');

  (0, _qunit.test)('visiting /home', function (assert) {
    visit('/home');

    andThen(function () {
      assert.equal(currentURL(), '/home');
    });
  });
});
define('ecommerce-custom-solutions/tests/acceptance/home-test.jshint', ['exports'], function (exports) {
  'use strict';

  QUnit.module('JSHint | acceptance/home-test.js');
  QUnit.test('should pass jshint', function (assert) {
    assert.expect(1);
    assert.ok(true, 'acceptance/home-test.js should pass jshint.');
  });
});
define('ecommerce-custom-solutions/tests/app.jshint', ['exports'], function (exports) {
  'use strict';

  QUnit.module('JSHint | app.js');
  QUnit.test('should pass jshint', function (assert) {
    assert.expect(1);
    assert.ok(true, 'app.js should pass jshint.');
  });
});
define('ecommerce-custom-solutions/tests/helpers/destroy-app', ['exports', 'ember'], function (exports, _ember) {
  exports['default'] = destroyApp;

  function destroyApp(application) {
    _ember['default'].run(application, 'destroy');
  }
});
define('ecommerce-custom-solutions/tests/helpers/destroy-app.jshint', ['exports'], function (exports) {
  'use strict';

  QUnit.module('JSHint | helpers/destroy-app.js');
  QUnit.test('should pass jshint', function (assert) {
    assert.expect(1);
    assert.ok(true, 'helpers/destroy-app.js should pass jshint.');
  });
});
define('ecommerce-custom-solutions/tests/helpers/module-for-acceptance', ['exports', 'qunit', 'ember', 'ecommerce-custom-solutions/tests/helpers/start-app', 'ecommerce-custom-solutions/tests/helpers/destroy-app'], function (exports, _qunit, _ember, _ecommerceCustomSolutionsTestsHelpersStartApp, _ecommerceCustomSolutionsTestsHelpersDestroyApp) {
  var Promise = _ember['default'].RSVP.Promise;

  exports['default'] = function (name) {
    var options = arguments.length <= 1 || arguments[1] === undefined ? {} : arguments[1];

    (0, _qunit.module)(name, {
      beforeEach: function beforeEach() {
        this.application = (0, _ecommerceCustomSolutionsTestsHelpersStartApp['default'])();

        if (options.beforeEach) {
          return options.beforeEach.apply(this, arguments);
        }
      },

      afterEach: function afterEach() {
        var _this = this;

        var afterEach = options.afterEach && options.afterEach.apply(this, arguments);
        return Promise.resolve(afterEach).then(function () {
          return (0, _ecommerceCustomSolutionsTestsHelpersDestroyApp['default'])(_this.application);
        });
      }
    });
  };
});
define('ecommerce-custom-solutions/tests/helpers/module-for-acceptance.jshint', ['exports'], function (exports) {
  'use strict';

  QUnit.module('JSHint | helpers/module-for-acceptance.js');
  QUnit.test('should pass jshint', function (assert) {
    assert.expect(1);
    assert.ok(true, 'helpers/module-for-acceptance.js should pass jshint.');
  });
});
define('ecommerce-custom-solutions/tests/helpers/resolver', ['exports', 'ecommerce-custom-solutions/resolver', 'ecommerce-custom-solutions/config/environment'], function (exports, _ecommerceCustomSolutionsResolver, _ecommerceCustomSolutionsConfigEnvironment) {

  var resolver = _ecommerceCustomSolutionsResolver['default'].create();

  resolver.namespace = {
    modulePrefix: _ecommerceCustomSolutionsConfigEnvironment['default'].modulePrefix,
    podModulePrefix: _ecommerceCustomSolutionsConfigEnvironment['default'].podModulePrefix
  };

  exports['default'] = resolver;
});
define('ecommerce-custom-solutions/tests/helpers/resolver.jshint', ['exports'], function (exports) {
  'use strict';

  QUnit.module('JSHint | helpers/resolver.js');
  QUnit.test('should pass jshint', function (assert) {
    assert.expect(1);
    assert.ok(true, 'helpers/resolver.js should pass jshint.');
  });
});
define('ecommerce-custom-solutions/tests/helpers/start-app', ['exports', 'ember', 'ecommerce-custom-solutions/app', 'ecommerce-custom-solutions/config/environment'], function (exports, _ember, _ecommerceCustomSolutionsApp, _ecommerceCustomSolutionsConfigEnvironment) {
  exports['default'] = startApp;

  function startApp(attrs) {
    var application = undefined;

    var attributes = _ember['default'].merge({}, _ecommerceCustomSolutionsConfigEnvironment['default'].APP);
    attributes = _ember['default'].merge(attributes, attrs); // use defaults, but you can override;

    _ember['default'].run(function () {
      application = _ecommerceCustomSolutionsApp['default'].create(attributes);
      application.setupForTesting();
      application.injectTestHelpers();
    });

    return application;
  }
});
define('ecommerce-custom-solutions/tests/helpers/start-app.jshint', ['exports'], function (exports) {
  'use strict';

  QUnit.module('JSHint | helpers/start-app.js');
  QUnit.test('should pass jshint', function (assert) {
    assert.expect(1);
    assert.ok(true, 'helpers/start-app.js should pass jshint.');
  });
});
define('ecommerce-custom-solutions/tests/resolver.jshint', ['exports'], function (exports) {
  'use strict';

  QUnit.module('JSHint | resolver.js');
  QUnit.test('should pass jshint', function (assert) {
    assert.expect(1);
    assert.ok(true, 'resolver.js should pass jshint.');
  });
});
define('ecommerce-custom-solutions/tests/router.jshint', ['exports'], function (exports) {
  'use strict';

  QUnit.module('JSHint | router.js');
  QUnit.test('should pass jshint', function (assert) {
    assert.expect(1);
    assert.ok(true, 'router.js should pass jshint.');
  });
});
define('ecommerce-custom-solutions/tests/routes/index.jshint', ['exports'], function (exports) {
  'use strict';

  QUnit.module('JSHint | routes/index.js');
  QUnit.test('should pass jshint', function (assert) {
    assert.expect(1);
    assert.ok(true, 'routes/index.js should pass jshint.');
  });
});
define('ecommerce-custom-solutions/tests/test-helper', ['exports', 'ecommerce-custom-solutions/tests/helpers/resolver', 'ember-qunit'], function (exports, _ecommerceCustomSolutionsTestsHelpersResolver, _emberQunit) {

  (0, _emberQunit.setResolver)(_ecommerceCustomSolutionsTestsHelpersResolver['default']);
});
define('ecommerce-custom-solutions/tests/test-helper.jshint', ['exports'], function (exports) {
  'use strict';

  QUnit.module('JSHint | test-helper.js');
  QUnit.test('should pass jshint', function (assert) {
    assert.expect(1);
    assert.ok(true, 'test-helper.js should pass jshint.');
  });
});
define('ecommerce-custom-solutions/tests/unit/routes/index-test', ['exports', 'ember-qunit'], function (exports, _emberQunit) {

  (0, _emberQunit.moduleFor)('route:index', 'Unit | Route | index', {
    // Specify the other units that are required for this test.
    // needs: ['controller:foo']
  });

  (0, _emberQunit.test)('it exists', function (assert) {
    var route = this.subject();
    assert.ok(route);
  });
});
define('ecommerce-custom-solutions/tests/unit/routes/index-test.jshint', ['exports'], function (exports) {
  'use strict';

  QUnit.module('JSHint | unit/routes/index-test.js');
  QUnit.test('should pass jshint', function (assert) {
    assert.expect(1);
    assert.ok(true, 'unit/routes/index-test.js should pass jshint.');
  });
});
/* jshint ignore:start */

require('ecommerce-custom-solutions/tests/test-helper');
EmberENV.TESTS_FILE_LOADED = true;

/* jshint ignore:end */
//# sourceMappingURL=tests.map
