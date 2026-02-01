<div style="position: fixed; top: 0; left: 250px; width: calc(100% - 250px); height: 64px; z-index: 1000; background: #fff; border-bottom: 2px solid #e3e3e3; box-shadow: 0 2px 8px rgba(0,0,0,0.04); display: flex; align-items: center; padding: 0 32px;">
    <div style="border-left: 6px solid #1976d2; padding-left: 18px; display: flex; align-items: center; height: 48px; flex: 1;">
        <span style="font-size: 2rem; font-weight: 700; color: #1976d2; margin-right: 18px; letter-spacing: 0.5px;">Dashboard Admin</span>
    </div>
    <span style="font-size: 1rem; color: #fff; background: #1976d2; border-radius: 6px; padding: 4px 16px; font-weight: 600; display: flex; align-items: center; gap: 6px; margin-left: auto;">
        <span style="font-size: 1.2em;">🔑</span> Role: <?php echo strtoupper($this->session->userdata('role')); ?>
    </span>
</div>