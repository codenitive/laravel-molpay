<?php

class Create_Molpays {
	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('molpays', function ($table)
		{
			$table->increments();
			
			$table->decimal('amount', 10, 2);
			$table->string('order_id');
			$table->string('app_id');
			$table->integer('transaction_id');
			$table->string('domain');
			$table->string('status', 2);
			$table->string('currency', 2);
			$table->date('paydate');
			$table->string('channel');
			$table->string('skey', 32);

			$table->timestamps();

			$table->index('transaction_id');
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('molpays');
	}
}