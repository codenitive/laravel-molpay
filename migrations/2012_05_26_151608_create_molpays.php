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
			
			$table->decimal('amount', 10, 2)->nullable();
			$table->string('order_id');
			$table->string('app_code')->nullable();
			$table->integer('transaction_id');
			$table->string('domain');
			$table->string('status', 2);
			$table->string('currency', 2);
			$table->date('paid_at');
			$table->string('channel');
			$table->string('error_code')->nullable();
			$table->string('error_description')->nullable();
			$table->string('security_key', 32)->nullable();

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