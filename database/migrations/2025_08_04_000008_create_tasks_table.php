    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class CreateTasksTable extends Migration
    {
        public function up()
        {
            Schema::create('tasks', function (Blueprint $table) {
                $table->id();
                $table->foreignId('project_id')->constrained()->cascadeOnDelete();
                $table->foreignId('assigned_to')->nullable()->constrained('employees')->nullOnDelete();
                $table->string('title');
                $table->text('description')->nullable();
                $table->date('due_date')->nullable();
                $table->enum('status', ['pending', 'in_progress', 'done'])->default('pending');
                $table->timestamps();
            });
        }

        public function down()
        {
            Schema::dropIfExists('tasks');
        }
    }
