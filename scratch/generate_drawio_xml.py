# -*- coding: utf-8 -*-
"""
Generate Draw.io (diagrams.net) XML for Service Layer Architecture of SD Negeri Lama.
"""

import xml.etree.ElementTree as ET
import os

def create_drawio_xml():
    mxfile = ET.Element('mxfile', {
        'host': 'app.diagrams.net',
        'modified': '2026-09-24T15:30:00.000Z',
        'agent': 'Antigravity',
        'version': '22.1.16',
        'type': 'device'
    })
    
    diagram = ET.SubElement(mxfile, 'diagram', {
        'id': 'service-layer-sdnl',
        'name': 'Arsitektur Service Layer - SD Negeri Lama'
    })
    
    model = ET.SubElement(diagram, 'mxGraphModel', {
        'dx': '1422',
        'dy': '850',
        'grid': '1',
        'gridSize': '10',
        'guides': '1',
        'tooltips': '1',
        'connect': '1',
        'arrows': '1',
        'fold': '1',
        'page': '1',
        'pageScale': '1',
        'pageWidth': '1400',
        'pageHeight': '1050',
        'math': '0',
        'shadow': '0'
    })
    
    root = ET.SubElement(model, 'root')
    
    # Base cells
    ET.SubElement(root, 'mxCell', {'id': '0'})
    ET.SubElement(root, 'mxCell', {'id': '1', 'parent': '0'})

    def add_cell(cell_id, value, style, x, y, w, h, parent='1', is_vertex=True):
        cell = ET.SubElement(root, 'mxCell', {
            'id': str(cell_id),
            'value': value,
            'style': style,
            'parent': str(parent),
            'vertex': '1' if is_vertex else '0'
        })
        geo = ET.SubElement(cell, 'mxGeometry', {
            'x': str(x),
            'y': str(y),
            'width': str(w),
            'height': str(h),
            'as': 'geometry'
        })
        return cell

    def add_edge(edge_id, source_id, target_id, label='', style='', waypoints=None):
        edge = ET.SubElement(root, 'mxCell', {
            'id': str(edge_id),
            'value': label,
            'style': style or 'edgeStyle=orthogonalEdgeStyle;rounded=1;orthogonalLoop=1;jettySize=auto;html=1;strokeColor=#475569;strokeWidth=2;fontSize=11;fontColor=#334155;',
            'parent': '1',
            'edge': '1',
            'source': str(source_id),
            'target': str(target_id)
        })
        geo = ET.SubElement(edge, 'mxGeometry', {
            'relative': '1',
            'as': 'geometry'
        })
        if waypoints:
            pts = ET.SubElement(geo, 'Array', {'as': 'points'})
            for wx, wy in waypoints:
                ET.SubElement(pts, 'mxPoint', {'x': str(wx), 'y': str(wy)})
        return edge

    # =========================================================================
    # 0. HEADER & TITLE
    # =========================================================================
    add_cell(
        'title_box',
        '<font style="font-size: 20px;"><b>DIAGRAM ARSITEKTUR SERVICE LAYER (CLEAN ARCHITECTURE)</b></font><br/>'
        '<font style="font-size: 13px; color: #64748B;">Sistem Informasi Manajemen Sekolah Terpadu, PPDB Online & Portal Guru - SD Negeri Lama (Laravel 13)</font>',
        'text;html=1;align=center;verticalAlign=middle;resizable=0;points=[];autosize=1;strokeColor=none;fillColor=none;',
        300, 20, 800, 50
    )

    # =========================================================================
    # 1. LAYER CONTAINERS (HORIZONTAL BANDS)
    # =========================================================================
    # Layer 1: Client / Presentation
    add_cell(
        'layer_client',
        '<b>1. CLIENT / USER INTERFACE LAYER (Bootstrap 5 Responsive & Mobile UI)</b>',
        'swimlane;html=1;startSize=28;rounded=1;arcSize=4;fillColor=#F0F9FF;strokeColor=#0284C7;strokeWidth=2;fontColor=#0369A1;fontSize=12;align=left;spacingLeft=15;',
        40, 90, 1320, 110
    )

    # Layer 2: HTTP Controller Layer
    add_cell(
        'layer_controller',
        '<b>2. PRESENTATION / CONTROLLER LAYER (app/Http/Controllers & Routes)</b>',
        'swimlane;html=1;startSize=28;rounded=1;arcSize=4;fillColor=#FAF5FF;strokeColor=#9333EA;strokeWidth=2;fontColor=#7E22CE;fontSize=12;align=left;spacingLeft=15;',
        40, 230, 1320, 130
    )

    # Layer 3: Service Layer (HIGHLIGHTED)
    add_cell(
        'layer_service',
        '<b>3. SERVICE LAYER / BUSINESS LOGIC LAYER (app/Services) — [PUSAT ATURAN BISNIS]</b>',
        'swimlane;html=1;startSize=32;rounded=1;arcSize=4;fillColor=#ECFDF5;strokeColor=#059669;strokeWidth=3;fontColor=#047857;fontSize=13;align=left;spacingLeft=15;shadow=1;',
        40, 390, 1320, 230
    )

    # Layer 4: Eloquent Model Layer
    add_cell(
        'layer_model',
        '<b>4. DATA PERSISTENCE / ORM LAYER (app/Models — Eloquent ORM)</b>',
        'swimlane;html=1;startSize=28;rounded=1;arcSize=4;fillColor=#FFFBEB;strokeColor=#D97706;strokeWidth=2;fontColor=#B45309;fontSize=12;align=left;spacingLeft=15;',
        40, 650, 1320, 120
    )

    # Layer 5: Infrastructure & Database
    add_cell(
        'layer_infra',
        '<b>5. INFRASTRUCTURE & STORAGE LAYER (MySQL, Local Disk, Dompdf & Ngrok)</b>',
        'swimlane;html=1;startSize=28;rounded=1;arcSize=4;fillColor=#F8FAFC;strokeColor=#475569;strokeWidth=2;fontColor=#334155;fontSize=12;align=left;spacingLeft=15;',
        40, 800, 1320, 130
    )

    # =========================================================================
    # 2. CLIENT NODES
    # =========================================================================
    client_style = 'rounded=1;whiteSpace=wrap;html=1;fillColor=#E0F2FE;strokeColor=#0284C7;strokeWidth=1.5;fontColor=#0F172A;fontSize=11;shadow=1;'
    
    add_cell('c_ppdb', '<b>Wali Murid / Pendaftar</b><br/>Formulir PPDB Online & Bukti Registrasi PDF<br/><i>(Mobile & Desktop View)</i>', client_style, 80, 125, 260, 60)
    add_cell('c_guru', '<b>Dewan Guru Pengajar</b><br/>Portal Presensi, Materi Ajar & Nilai Siswa<br/><i>(Mobile Card & Tablet View)</i>', client_style, 400, 125, 270, 60)
    add_cell('c_admin', '<b>Administrator Sekolah</b><br/>Dashboard Rekap, Verifikasi & Master Setting<br/><i>(Admin Dashboard UI)</i>', client_style, 730, 125, 270, 60)
    add_cell('c_public', '<b>Pengunjung Publik</b><br/>Profil Sekolah, Galeri, Fasilitas & Pengumuman<br/><i>(Web Portal Beranda)</i>', client_style, 1060, 125, 260, 60)

    # =========================================================================
    # 3. CONTROLLER NODES
    # =========================================================================
    ctrl_style = 'rounded=1;whiteSpace=wrap;html=1;fillColor=#F3E8FF;strokeColor=#9333EA;strokeWidth=1.5;fontColor=#3B0764;fontSize=11;shadow=1;'
    
    add_cell(
        'ctrl_ppdb',
        '<b>PpdbController</b><br/>'
        '• index(), store()<br/>'
        '• exportPdf(), exportExcel()<br/>'
        '• updateStatus()',
        ctrl_style, 80, 270, 260, 75
    )
    add_cell(
        'ctrl_guru',
        '<b>GuruController</b><br/>'
        '• dashboard(), myClasses()<br/>'
        '• storeAttendance()<br/>'
        '• uploadMaterial(), gradeTask()',
        ctrl_style, 400, 270, 270, 75
    )
    add_cell(
        'ctrl_admin',
        '<b>AdminController</b><br/>'
        '• dashboard(), stats()<br/>'
        '• manageAnnouncements()<br/>'
        '• updateSettings()',
        ctrl_style, 730, 270, 270, 75
    )
    add_cell(
        'ctrl_home',
        '<b>HomeController</b><br/>'
        '• index(), profile()<br/>'
        '• facilities(), gallery()<br/>'
        '• announcements()',
        ctrl_style, 1060, 270, 260, 75
    )

    # =========================================================================
    # 4. SERVICE LAYER NODES (DETAILED WITH METHODS)
    # =========================================================================
    srv_style = 'rounded=1;whiteSpace=wrap;html=1;fillColor=#D1FAE5;strokeColor=#059669;strokeWidth=2;fontColor=#064E3B;fontSize=11;shadow=1;'
    
    add_cell(
        'srv_ppdb',
        '<b>PpdbService</b><br/>'
        '<div style="text-align: left; font-size: 10px; line-height: 1.3;">'
        '• <b>generateRegistrationNumber()</b>: Unique RegNo<br/>'
        '• <b>register(array $data)</b>: Simpan Pendaftar Baru<br/>'
        '• <b>generatePdfExport($settings)</b>: Render Dompdf<br/>'
        '• <b>exportExcelData()</b>: Rekapitulasi Rombel<br/>'
        '• <b>updateRegistrationStatus()</b>: Validasi Seleksi'
        '</div>',
        srv_style, 80, 435, 260, 160
    )

    add_cell(
        'srv_guru',
        '<b>GuruService</b><br/>'
        '<div style="text-align: left; font-size: 10px; line-height: 1.3;">'
        '• <b>getDashboardData($user)</b>: Agregasi Statistik Guru<br/>'
        '• <b>getKelasData(Request, $user)</b>: Data Rombel<br/>'
        '• <b>recordAttendance(array $records)</b>: Presensi Siswa<br/>'
        '• <b>uploadMateri(Request)</b>: Manajemen File Modul<br/>'
        '• <b>curateVideo(Request)</b>: Filter Video Edukasi<br/>'
        '• <b>gradeAssignment()</b>: Evaluasi Standar KKM 75'
        '</div>',
        srv_style, 400, 435, 270, 160
    )

    add_cell(
        'srv_dash',
        '<b>DashboardService</b><br/>'
        '<div style="text-align: left; font-size: 10px; line-height: 1.3;">'
        '• <b>getAdminDashboardData()</b>: Metrik Statistik Terpadu<br/>'
        '• <b>getInformationHubData()</b>: Feed Berita & Agenda<br/>'
        '• <b>calculateRombelRatios()</b>: Rasio Siswa-Guru<br/>'
        '• <b>getActivityLogs()</b>: Riwayat Aktivitas Sistem'
        '</div>',
        srv_style, 730, 435, 270, 160
    )

    add_cell(
        'srv_content',
        '<b>WebsiteContentService</b><br/>'
        '<div style="text-align: left; font-size: 10px; line-height: 1.3;">'
        '• <b>getLandingPageData()</b>: Visi-Misi, Profil ANBK<br/>'
        '• <b>getSchoolSettings()</b>: Identitas & Kontak Resmi<br/>'
        '• <b>filterActiveAnnouncements()</b>: Berita Terbit<br/>'
        '• <b>sanitizePublicInputs()</b>: Validasi Input Publik'
        '</div>',
        srv_style, 1060, 435, 260, 160
    )

    # =========================================================================
    # 5. ELOQUENT MODEL NODES
    # =========================================================================
    model_style = 'rounded=1;whiteSpace=wrap;html=1;fillColor=#FEF3C7;strokeColor=#D97706;strokeWidth=1.5;fontColor=#78350F;fontSize=11;shadow=1;'
    
    add_cell(
        'm_ppdb',
        '<b>PpdbRegistration</b><br/>'
        '<font style="font-size: 10px;">Attributes: id, reg_number, full_name, nisn, gender, status, birth_date</font>',
        model_style, 80, 690, 260, 60
    )

    add_cell(
        'm_guru',
        '<b>Student, Attendance, Assignment, Grade</b><br/>'
        '<font style="font-size: 10px;">LearningMaterial, EducationalVideo<br/>Relasi: Student hasMany Attendance, Assignment hasMany Grade</font>',
        model_style, 400, 690, 270, 60
    )

    add_cell(
        'm_admin',
        '<b>Announcement, Feature, SchoolSetting</b><br/>'
        '<font style="font-size: 10px;">User, Role, ActivityLog<br/>Relasi: User hasMany ActivityLog, Feature scopeActive</font>',
        model_style, 730, 690, 270, 60
    )

    add_cell(
        'm_public',
        '<b>SchoolSetting, Feature, Gallery</b><br/>'
        '<font style="font-size: 10px;">Data Identitas Sekolah, Akreditasi A, Laboratorium Komputer ANBK & Sarpras</font>',
        model_style, 1060, 690, 260, 60
    )

    # =========================================================================
    # 6. INFRASTRUCTURE & STORAGE NODES
    # =========================================================================
    infra_style = 'rounded=1;whiteSpace=wrap;html=1;fillColor=#E2E8F0;strokeColor=#475569;strokeWidth=1.5;fontColor=#0F172A;fontSize=11;shadow=1;'
    
    add_cell(
        'db_mysql',
        '<b>MySQL Database Server</b><br/>'
        '<font style="font-size: 10px;">Engine: InnoDB (UTF-8)<br/>Tabel: ppdb_registrations, students, attendances, materials, assignments, users</font>',
        'shape=cylinder3;whiteSpace=wrap;html=1;boundedLbl=1;backgroundOutline=1;size=15;fillColor=#E2E8F0;strokeColor=#475569;strokeWidth=1.5;fontColor=#0F172A;fontSize=11;',
        240, 835, 280, 80
    )

    add_cell(
        'fs_storage',
        '<b>Storage File System</b><br/>'
        '<font style="font-size: 10px;">storage/app/public/<br/>• Modul Ajar PDF / DOCX<br/>• Foto Profil & Banner Sekolah</font>',
        infra_style, 560, 840, 240, 70
    )

    add_cell(
        'ext_dompdf',
        '<b>Dompdf Library</b><br/>'
        '<font style="font-size: 10px;">Render Bukti Registrasi & Rekapitulasi Data Format PDF A4 / Landscape</font>',
        infra_style, 830, 840, 230, 70
    )

    add_cell(
        'ext_ngrok',
        '<b>Ngrok Tunneling</b><br/>'
        '<font style="font-size: 10px;">Reverse Proxy HTTPS Tunnel untuk Pengujian Live Perangkat Mobile Pengguna</font>',
        infra_style, 1090, 840, 230, 70
    )

    # =========================================================================
    # 7. CONNECTING EDGES (DATA & CONTROL FLOW)
    # =========================================================================
    flow_down = 'edgeStyle=orthogonalEdgeStyle;rounded=1;orthogonalLoop=1;jettySize=auto;html=1;strokeColor=#2563EB;strokeWidth=2;fontSize=10;fontColor=#1E40AF;'
    flow_up   = 'edgeStyle=orthogonalEdgeStyle;rounded=1;orthogonalLoop=1;jettySize=auto;html=1;strokeColor=#059669;strokeWidth=2;dashed=1;fontSize=10;fontColor=#065F46;'
    flow_db   = 'edgeStyle=orthogonalEdgeStyle;rounded=1;orthogonalLoop=1;jettySize=auto;html=1;strokeColor=#D97706;strokeWidth=2;fontSize=10;fontColor=#92400E;'

    # Client -> Controller
    add_edge('e1', 'c_ppdb', 'ctrl_ppdb', '1. HTTP Request (POST/GET)', flow_down)
    add_edge('e2', 'c_guru', 'ctrl_guru', '1. HTTP Request (Presensi/Materi)', flow_down)
    add_edge('e3', 'c_admin', 'ctrl_admin', '1. HTTP Request (Dashboard)', flow_down)
    add_edge('e4', 'c_public', 'ctrl_home', '1. HTTP Request (View Portal)', flow_down)

    # Controller -> Service (DELEGASI BISNIS)
    add_edge('e5', 'ctrl_ppdb', 'srv_ppdb', '2. Delegasi Logika Bisnis', 'edgeStyle=orthogonalEdgeStyle;rounded=1;orthogonalLoop=1;jettySize=auto;html=1;strokeColor=#9333EA;strokeWidth=2.5;fontSize=10;fontColor=#6B21A8;')
    add_edge('e6', 'ctrl_guru', 'srv_guru', '2. Delegasi Logika Pengajaran', 'edgeStyle=orthogonalEdgeStyle;rounded=1;orthogonalLoop=1;jettySize=auto;html=1;strokeColor=#9333EA;strokeWidth=2.5;fontSize=10;fontColor=#6B21A8;')
    add_edge('e7', 'ctrl_admin', 'srv_dash', '2. Delegasi Kalkulasi Metrik', 'edgeStyle=orthogonalEdgeStyle;rounded=1;orthogonalLoop=1;jettySize=auto;html=1;strokeColor=#9333EA;strokeWidth=2.5;fontSize=10;fontColor=#6B21A8;')
    add_edge('e8', 'ctrl_home', 'srv_content', '2. Delegasi Ekstraksi Konten', 'edgeStyle=orthogonalEdgeStyle;rounded=1;orthogonalLoop=1;jettySize=auto;html=1;strokeColor=#9333EA;strokeWidth=2.5;fontSize=10;fontColor=#6B21A8;')

    # Service -> Models (PERSISTENSI DATA)
    add_edge('e9', 'srv_ppdb', 'm_ppdb', '3. Create / Query Data', flow_db)
    add_edge('e10', 'srv_guru', 'm_guru', '3. Eloquent Relations & Query', flow_db)
    add_edge('e11', 'srv_dash', 'm_admin', '3. Aggregation Query (count/sum)', flow_db)
    add_edge('e12', 'srv_content', 'm_public', '3. Get Active Settings', flow_db)

    # Models -> Database
    add_edge('e13', 'm_ppdb', 'db_mysql', '4. SQL Execution', flow_db)
    add_edge('e14', 'm_guru', 'db_mysql', '4. SQL Execution', flow_db)
    add_edge('e15', 'm_admin', 'db_mysql', '4. SQL Execution', flow_db)
    add_edge('e16', 'm_public', 'db_mysql', '4. SQL Execution', flow_db)

    # Service -> Storage / Dompdf
    add_edge('e17', 'srv_ppdb', 'ext_dompdf', 'Cetak PDF Laporan', 'edgeStyle=orthogonalEdgeStyle;rounded=1;orthogonalLoop=1;jettySize=auto;html=1;strokeColor=#059669;strokeWidth=1.5;fontSize=9;fontColor=#065F46;', waypoints=[(320, 615), (320, 780), (945, 780)])
    add_edge('e18', 'srv_guru', 'fs_storage', 'Simpan Berkas Materi', 'edgeStyle=orthogonalEdgeStyle;rounded=1;orthogonalLoop=1;jettySize=auto;html=1;strokeColor=#059669;strokeWidth=1.5;fontSize=9;fontColor=#065F46;', waypoints=[(580, 615), (580, 785), (680, 785)])

    # Client -> Ngrok (Remote Access)
    add_edge('e19', 'c_public', 'ext_ngrok', 'Akses Mobile Via Tunnel', 'edgeStyle=orthogonalEdgeStyle;rounded=1;orthogonalLoop=1;jettySize=auto;html=1;strokeColor=#0284C7;strokeWidth=1.5;dashed=1;fontSize=9;fontColor=#0369A1;', waypoints=[(1340, 185), (1340, 875), (1320, 875)])

    # Format XML
    xml_str = ET.tostring(mxfile, encoding='utf-8')
    import xml.dom.minidom
    dom = xml.dom.minidom.parseString(xml_str)
    pretty_xml = dom.toprettyxml(indent="  ")
    
    return pretty_xml

if __name__ == '__main__':
    xml_content = create_drawio_xml()
    out_path = r'c:\backup\laragon\www\SDNegeriLama\diagram_service_layer.xml'
    with open(out_path, 'w', encoding='utf-8') as f:
        f.write(xml_content)
    print(f'Successfully generated Draw.io XML at: {out_path}')
    print(f'XML size: {len(xml_content)} characters')
