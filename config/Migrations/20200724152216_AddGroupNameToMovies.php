<?php
use Migrations\AbstractMigration;

class AddGroupNameToMovies extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function up() {
        $table = $this->table('movies');
        $table->addColumn('group_name', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->update();
    }

    public function down() {
        $table = $this->table('movies');
        $table->removeColumn('movies');
        $table->update();
    }
}
