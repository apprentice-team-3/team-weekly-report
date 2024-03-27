<div class="task__container">
    <h2 class="project__container">
        <div class="project__detail">
          　<?php echo $project->title ?>
          <script>
            const progress = Number("<?php echo $project->progress ?>")
            const progressPercent = progress.toFixed(4)
            document.write(progressPercent + "%")
          </script>
          完了
        </div>
    </h2>
</div>
