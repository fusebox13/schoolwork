<div>
<table>
    <tr>
        <th>Model</th>
        <th>Price</th>
        <th>Type</th>
    </tr>
    <?php
        while ($row=$browse_data->fetchObject()) {
            echo "<tr>";
            echo "<td>$row->model</td>";
            echo "<td>$row->price</td>";
            echo "<td>$row->type</td>";
            echo "</tr>";
        }
    ?>
</table>
<a href="index.php?action=add">Add a record</a>
</div>