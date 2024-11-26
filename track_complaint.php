<tbody>
  <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
      <td><?= htmlspecialchars($row['id']) ?></td>
      <td>
        <a href="complaint_details.php?id=<?= urlencode($row['id']) ?>">
          <?= htmlspecialchars($row['title']) ?>
        </a>
      </td>
      <td><?= htmlspecialchars($row['status']) ?></td>
      <td><?= htmlspecialchars($row['created_at']) ?></td>
    </tr>
  <?php endwhile; ?>
</tbody>



// การเชื่อมโยง
แก้ไขลิงก์ในหน้า HTML หลักให้ชี้ไปที่ไฟล์ track_complaint.php และส่ง username เป็น parameter เช่น:
<a href="track_complaint.php?username=<?= urlencode($username) ?>">ติดตามรายงานผลการร้องทุกข์ / ร้องเรียน</a>
