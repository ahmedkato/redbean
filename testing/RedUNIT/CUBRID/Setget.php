<?php

namespace RedUNIT\CUBRID;

//Using the following RedBeanPHP Components:
use RedBean\Facade as R;
use RedBean\RException\Security;

/**
 * Setget
 *
 * @file    RedUNIT/CUBRID/Setget.php
 * @desc    Tests whether values are stored correctly.
 * @author  Gabor de Mooij and the RedBeanPHP Community
 * @license New BSD/GPLv2
 *
 * (c) G.J.G.T. (Gabor) de Mooij and the RedBeanPHP Community.
 * This source file is subject to the New BSD/GPLv2 License that is bundled
 * with this source code in the file license.txt.
 */
class Setget extends \RedUNIT\CUBRID
{
	/**
	 * Test numbers.
	 * 
	 * @return void
	 */
	public function testNumbers()
	{
		asrt( setget( "-1" ), "-1" );
		asrt( setget( -1 ), "-1" );

		asrt( setget( "-0.25" ), "-0.2500000000000000" );
		asrt( setget( -0.25 ), "-0.2500000000000000" );

		asrt( setget( "0.12345678" ), "0.1234567800000000" );
		asrt( setget( 0.12345678 ), "0.1234567800000000" );

		asrt( setget( "-0.12345678" ), "-0.1234567800000000" );
		asrt( setget( -0.12345678 ), "-0.1234567800000000" );

		asrt( setget( "2147483647" ), "2147483647" );
		asrt( setget( 2147483647 ), "2147483647" );

		asrt( setget( -2147483647 ), "-2147483647" );
		asrt( setget( "-2147483647" ), "-2147483647" );

		asrt( setget( "2147483648" ), "2147483648.0000000000000000" );
		asrt( setget( "-2147483648" ), "-2147483648.0000000000000000" );

		asrt( setget( "199936710040730" ), "199936710040730.0000000000000000" );
		asrt( setget( "-199936710040730" ), "-199936710040730.0000000000000000" );
	}

	/**
	 * Test dates.
	 * 
	 * @return void
	 */
	public function testDates()
	{
		asrt( setget( "2010-10-11" ), "2010-10-11" );

		asrt( setget( "2010-10-11 12:10" ), "2010-10-11 12:10" );

		asrt( setget( "2010-10-11 12:10:11" ), "2010-10-11 12:10:11.000" );

		asrt( setget( "x2010-10-11 12:10:11" ), "x2010-10-11 12:10:11" );
	}

	/**
	 * Test strings.
	 * 
	 * @return void
	 */
	public function testStrings()
	{
		asrt( setget( "a" ), "a" );

		asrt( setget( "." ), "." );

		asrt( setget( "\"" ), "\"" );

		asrt( setget( "just some text" ), "just some text" );
	}

	/**
	 * Test booleans.
	 * 
	 * @return void
	 */
	public function testBool()
	{
		asrt( setget( true ), "1" );
		asrt( setget( false ), "0" );

		asrt( setget( "true" ), "true" );
		asrt( setget( "false" ), "false" );
	}

	/**
	 * Test NULL.
	 * 
	 * @return void
	 */
	public function testNull()
	{
		asrt( setget( "null" ), "null" );
		asrt( setget( "NULL" ), "NULL" );

		asrt( setget( "0123", 1 ), "0123" );
		asrt( setget( "0000123", 1 ), "0000123" );

		asrt( setget( null ), null );

		asrt( ( setget( 0 ) == 0 ), true );
		asrt( ( setget( 1 ) == 1 ), true );

		asrt( ( setget( true ) == true ), true );
		asrt( ( setget( false ) == false ), true );

		// minor test sqltest
		$a = R::$writer->sqlStateIn( '000', array() );

		// Unknown state must return false.
		asrt( $a, false );

		try {
			R::$writer->esc( '`aaa`' );

			fail();
		} catch (\Exception $e ) {
			pass();
		}

		asrt( ( $e instanceof Security ), true );
	}
}
