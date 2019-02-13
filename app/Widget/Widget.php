<?php
namespace App\Widget;

use Closure;
use Illuminate\Container\Container;
use Illuminate\Support\Str;
use Illuminate\View\Compilers\BladeCompiler;

class Widget
{
    protected $container;

    protected $blade;

    protected $groups = array();

    protected $widgets = array();

    public function __construct( Container $container, BladeCompiler $blade )
    {
        $this->container = $container;
        $this->blade     = $blade;
    }

    public function register( $name, $callback )
    {
        $this->widgets[ $name ] = $callback;

        $this->registerTag( $name );
    }

    protected function registerTag( $method )
    {
        $this->blade->directive( $method, function ( $expression ) use ( $method ) {
            return '<?php echo \Widget::' . $method . $expression . '; ?>';
        } );
    }

    public function exists( $name )
    {
        return array_key_exists( $name, $this->widgets );
    }

    public function call( $name, array $parameters = array() )
    {

        if ( $this->groupExists( $name ) ) return $this->callGroup( $name, $parameters );

        if ( $this->exists( $name ) ) {

            $callback = $this->widgets[ $name ];

            return $this->getCallback( $callback, $parameters );
        }

        return null;
    }

    public function attribute( $name, $attr )
    {
        if ( $this->exists( $name ) ) {
            $name  = $this->widgets[ $name ];
            $class = new \ReflectionClass( $name );

            if ( $class->hasProperty( $attr ) ) {
                $properties = $class->getDefaultProperties();

                return $properties[ $attr ];
            }
        }

        return null;
    }

    public function method( $name, $dataSource )
    {
        if ( $this->exists( $name ) ) {
            $name     = $this->widgets[ $name ];
            $class    = new \ReflectionClass( $name );
            $instance = $class->newInstanceArgs();

            return $instance->$dataSource();
        }

        return null;
    }

    public function view( $name, $dataSourceView )
    {
        $name = ucfirst( $name );

        if ( $this->exists( $name ) ) {
            $dataSourceView = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . $name . DIRECTORY_SEPARATOR . 'View' . DIRECTORY_SEPARATOR . $dataSourceView;

            view()->addNamespace( $name, dirname( $dataSourceView ) );

            return View( $name . '::' . basename( $dataSourceView ) );
        }
    }

    protected function getCallback( $callback, array $parameters )
    {
        if ( $callback instanceof Closure ) {
            return $this->createCallableCallback( $callback, $parameters );
        } elseif ( is_string( $callback ) ) {
            return $this->createStringCallback( $callback, $parameters );
        } else {
            return null;
        }
    }

    protected function createStringCallback( $callback, array $parameters )
    {
        if ( function_exists( $callback ) ) {
            return $this->createCallableCallback( $callback, $parameters );
        } else {
            return $this->createClassCallback( $callback, $parameters );
        }
    }

    protected function createCallableCallback( $callback, array $parameters )
    {
        return call_user_func_array( $callback, $parameters );
    }

    protected function createClassCallback( $callback, array $parameters )
    {
        list( $className, $method ) = Str::parseCallback( $callback, 'run' );

        $instance = $this->container->make( $className );

        $callable = array( $instance, $method );

        return $this->createCallableCallback( $callable, $parameters );
    }

    public function group( $name, array $widgets )
    {
        $this->groups[ $name ] = $widgets;

        $this->registerTag( $name );
    }

    public function groupExists( $name )
    {
        return array_key_exists( $name, $this->groups );
    }

    public function callGroup( $name, $parameters = array() )
    {
        if ( !$this->groupExists( $name ) ) return null;

        $result = '';

        foreach ( $this->groups[ $name ] as $key => $plugin ) {
            $result .= $this->call( $plugin, array_get( $parameters, $key, array() ) );
        }

        return $result;
    }

    public function __call( $method, $parameters = array() )
    {
        return $this->call( $method, $parameters );
    }
}