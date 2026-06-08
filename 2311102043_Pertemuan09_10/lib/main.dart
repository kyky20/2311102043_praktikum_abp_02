import 'dart:ui';

import 'package:firebase_core/firebase_core.dart';
import 'package:firebase_messaging/firebase_messaging.dart';
import 'package:flutter/material.dart';
import 'package:provider/provider.dart';

@pragma('vm:entry-point')
Future<void> firebaseMessagingBackgroundHandler(RemoteMessage message) async {
  await Firebase.initializeApp();
}

Future<void> main() async {
  WidgetsFlutterBinding.ensureInitialized();
  FirebaseMessaging.onBackgroundMessage(firebaseMessagingBackgroundHandler);

  final notificationProvider = NotificationProvider();
  await notificationProvider.initialize();

  runApp(TodoApp(notificationProvider: notificationProvider));
}

class TodoProvider extends ChangeNotifier {
  final List<String> _tasks = [];
  final Set<int> _selectedIndexes = {};

  List<String> get tasks => List.unmodifiable(_tasks);

  int get totalTasks => _tasks.length;
  int get selectedCount => _selectedIndexes.length;

  void addTask(String task) {
    final trimmedTask = task.trim();
    if (trimmedTask.isEmpty) {
      return;
    }

    _tasks.add(trimmedTask);
    notifyListeners();
  }

  bool isSelected(int index) {
    return _selectedIndexes.contains(index);
  }

  void toggleTaskSelection(int index) {
    if (_selectedIndexes.contains(index)) {
      _selectedIndexes.remove(index);
    } else {
      _selectedIndexes.add(index);
    }
    notifyListeners();
  }

  void deleteSelectedTasks() {
    final selectedIndexes = _selectedIndexes.toList()
      ..sort((first, second) => second.compareTo(first));

    for (final index in selectedIndexes) {
      if (index >= 0 && index < _tasks.length) {
        _tasks.removeAt(index);
      }
    }

    _selectedIndexes.clear();
    notifyListeners();
  }

  void clearTasks() {
    _tasks.clear();
    _selectedIndexes.clear();
    notifyListeners();
  }
}

class NotificationProvider extends ChangeNotifier {
  bool _isFirebaseReady = false;
  String? _fcmToken;
  String? _lastTitle;
  String? _lastBody;
  String? _errorMessage;

  bool get isFirebaseReady => _isFirebaseReady;
  String? get fcmToken => _fcmToken;
  String? get lastTitle => _lastTitle;
  String? get lastBody => _lastBody;
  String? get errorMessage => _errorMessage;

  Future<void> initialize() async {
    try {
      await Firebase.initializeApp();

      final messaging = FirebaseMessaging.instance;
      await messaging.requestPermission();
      _fcmToken = await messaging.getToken();
      debugPrint('FCM TOKEN: $_fcmToken');

      FirebaseMessaging.onMessage.listen(_saveMessage);
      FirebaseMessaging.onMessageOpenedApp.listen(_saveMessage);

      final initialMessage = await messaging.getInitialMessage();
      if (initialMessage != null) {
        _saveMessage(initialMessage);
      }

      _isFirebaseReady = true;
    } on Object catch (error) {
      _errorMessage =
          'Firebase belum aktif. Tambahkan konfigurasi Firebase lalu jalankan ulang aplikasi.';
      debugPrint('Firebase initialization error: $error');
    }

    notifyListeners();
  }

  void _saveMessage(RemoteMessage message) {
    _lastTitle = message.notification?.title ?? message.data['title'];
    _lastBody = message.notification?.body ?? message.data['body'];
    notifyListeners();
  }
}

class TodoApp extends StatelessWidget {
  const TodoApp({super.key, required this.notificationProvider});

  final NotificationProvider notificationProvider;

  @override
  Widget build(BuildContext context) {
    return MultiProvider(
      providers: [
        ChangeNotifierProvider(create: (_) => TodoProvider()),
        ChangeNotifierProvider.value(value: notificationProvider),
      ],
      child: MaterialApp(
        debugShowCheckedModeBanner: false,
        title: 'To-Do Provider FCM',
        theme: ThemeData(
          colorScheme: ColorScheme.fromSeed(
            seedColor: const Color(0xFF2563EB),
            primary: const Color(0xFF2563EB),
            secondary: const Color(0xFF14B8A6),
          ),
          scaffoldBackgroundColor: const Color(0xFFEFF6FF),
          fontFamily: 'Roboto',
          inputDecorationTheme: InputDecorationTheme(
            filled: true,
            fillColor: Colors.white.withValues(alpha: 0.70),
            border: OutlineInputBorder(
              borderRadius: BorderRadius.circular(8),
              borderSide: BorderSide(
                color: Colors.white.withValues(alpha: 0.70),
              ),
            ),
            enabledBorder: OutlineInputBorder(
              borderRadius: BorderRadius.circular(8),
              borderSide: BorderSide(
                color: Colors.white.withValues(alpha: 0.70),
              ),
            ),
            focusedBorder: OutlineInputBorder(
              borderRadius: BorderRadius.circular(8),
              borderSide: const BorderSide(color: Color(0xFF2563EB), width: 2),
            ),
          ),
          filledButtonTheme: FilledButtonThemeData(
            style: FilledButton.styleFrom(
              shape: RoundedRectangleBorder(
                borderRadius: BorderRadius.circular(8),
              ),
            ),
          ),
          useMaterial3: true,
        ),
        home: const TodoPage(),
      ),
    );
  }
}

class TodoPage extends StatefulWidget {
  const TodoPage({super.key});

  @override
  State<TodoPage> createState() => _TodoPageState();
}

class _TodoPageState extends State<TodoPage> {
  final TextEditingController _taskController = TextEditingController();

  @override
  void dispose() {
    _taskController.dispose();
    super.dispose();
  }

  void _addTask() {
    context.read<TodoProvider>().addTask(_taskController.text);
    _taskController.clear();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: DecoratedBox(
        decoration: const BoxDecoration(
          gradient: LinearGradient(
            begin: Alignment.topLeft,
            end: Alignment.bottomRight,
            colors: [Color(0xFFE0F2FE), Color(0xFFF8FAFC), Color(0xFFCCFBF1)],
          ),
        ),
        child: SafeArea(
          child: ListView(
            padding: const EdgeInsets.fromLTRB(16, 18, 16, 24),
            children: [
              const _HeroHeader(),
              const SizedBox(height: 18),
              _TaskInput(controller: _taskController, onSubmit: _addTask),
              const SizedBox(height: 18),
              const _TaskSummary(),
              const SizedBox(height: 12),
              const _TaskList(),
              const SizedBox(height: 18),
              const _FcmStatus(),
            ],
          ),
        ),
      ),
    );
  }
}

class _HeroHeader extends StatelessWidget {
  const _HeroHeader();

  @override
  Widget build(BuildContext context) {
    final totalTasks = context.watch<TodoProvider>().totalTasks;
    final selectedCount = context.watch<TodoProvider>().selectedCount;

    return _Surface(
      padding: const EdgeInsets.all(20),
      child: Padding(
        padding: EdgeInsets.zero,
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Text(
              'To-Do Provider FCM',
              style: Theme.of(context).textTheme.headlineSmall?.copyWith(
                color: const Color(0xFF0F172A),
                fontWeight: FontWeight.w800,
              ),
            ),
            const SizedBox(height: 4),
            Text(
              'Provider untuk daftar tugas, FCM untuk notifikasi.',
              style: Theme.of(
                context,
              ).textTheme.bodyMedium?.copyWith(color: const Color(0xFF475569)),
            ),
            const SizedBox(height: 18),
            Row(
              children: [
                _HeaderStat(label: 'Total tugas', value: '$totalTasks'),
                const SizedBox(width: 10),
                _HeaderStat(label: 'Dipilih', value: '$selectedCount'),
              ],
            ),
          ],
        ),
      ),
    );
  }
}

class _HeaderStat extends StatelessWidget {
  const _HeaderStat({required this.label, required this.value});

  final String label;
  final String value;

  @override
  Widget build(BuildContext context) {
    return Expanded(
      child: DecoratedBox(
        decoration: BoxDecoration(
          color: Colors.white.withValues(alpha: 0.42),
          borderRadius: BorderRadius.circular(8),
          border: Border.all(color: Colors.white.withValues(alpha: 0.65)),
        ),
        child: Padding(
          padding: const EdgeInsets.all(12),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Text(
                value,
                style: Theme.of(context).textTheme.titleLarge?.copyWith(
                  color: const Color(0xFF0F172A),
                  fontWeight: FontWeight.w800,
                ),
              ),
              const SizedBox(height: 2),
              Text(
                label,
                overflow: TextOverflow.ellipsis,
                style: Theme.of(context).textTheme.labelMedium?.copyWith(
                  color: const Color(0xFF64748B),
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }
}

class _TaskInput extends StatelessWidget {
  const _TaskInput({required this.controller, required this.onSubmit});

  final TextEditingController controller;
  final VoidCallback onSubmit;

  @override
  Widget build(BuildContext context) {
    return _Surface(
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          const _SectionTitle(
            title: 'Tambah tugas',
            subtitle: 'Masukkan aktivitas yang ingin dikerjakan.',
          ),
          const SizedBox(height: 14),
          Row(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Expanded(
                child: TextField(
                  controller: controller,
                  decoration: const InputDecoration(
                    labelText: 'Nama tugas',
                    hintText: 'Contoh: Kerjakan laporan ABP',
                  ),
                  onSubmitted: (_) => onSubmit(),
                ),
              ),
              const SizedBox(width: 10),
              SizedBox(
                height: 56,
                child: FilledButton.icon(
                  onPressed: onSubmit,
                  icon: const Icon(Icons.add),
                  label: const Text('Tambah'),
                ),
              ),
            ],
          ),
        ],
      ),
    );
  }
}

class _SectionTitle extends StatelessWidget {
  const _SectionTitle({required this.title, required this.subtitle});

  final String title;
  final String subtitle;

  @override
  Widget build(BuildContext context) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Text(
          title,
          style: Theme.of(context).textTheme.titleMedium?.copyWith(
            fontWeight: FontWeight.w800,
            color: const Color(0xFF0F172A),
          ),
        ),
        const SizedBox(height: 2),
        Text(
          subtitle,
          style: Theme.of(
            context,
          ).textTheme.bodySmall?.copyWith(color: const Color(0xFF64748B)),
        ),
      ],
    );
  }
}

class _Surface extends StatelessWidget {
  const _Surface({
    required this.child,
    this.padding = const EdgeInsets.all(16),
  });

  final Widget child;
  final EdgeInsetsGeometry padding;

  @override
  Widget build(BuildContext context) {
    return ClipRRect(
      borderRadius: BorderRadius.circular(8),
      child: BackdropFilter(
        filter: ImageFilter.blur(sigmaX: 16, sigmaY: 16),
        child: DecoratedBox(
          decoration: BoxDecoration(
            color: Colors.white.withValues(alpha: 0.46),
            borderRadius: BorderRadius.circular(8),
            border: Border.all(color: Colors.white.withValues(alpha: 0.70)),
            boxShadow: const [
              BoxShadow(
                color: Color(0x120F172A),
                blurRadius: 22,
                offset: Offset(0, 10),
              ),
            ],
          ),
          child: Padding(padding: padding, child: child),
        ),
      ),
    );
  }
}

class _StatusChip extends StatelessWidget {
  const _StatusChip({required this.label, required this.color});

  final String label;
  final Color color;

  @override
  Widget build(BuildContext context) {
    return Container(
      constraints: const BoxConstraints(minHeight: 38),
      padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 8),
      decoration: BoxDecoration(
        color: color.withValues(alpha: 0.10),
        borderRadius: BorderRadius.circular(8),
        border: Border.all(color: color.withValues(alpha: 0.18)),
      ),
      child: Row(
        mainAxisSize: MainAxisSize.min,
        children: [
          Text(
            label,
            style: Theme.of(context).textTheme.labelLarge?.copyWith(
              color: color,
              fontWeight: FontWeight.w700,
            ),
          ),
        ],
      ),
    );
  }
}

class _TaskSummary extends StatelessWidget {
  const _TaskSummary();

  @override
  Widget build(BuildContext context) {
    final todoProvider = context.watch<TodoProvider>();
    final totalTasks = todoProvider.totalTasks;
    final selectedCount = todoProvider.selectedCount;

    return Column(
      crossAxisAlignment: CrossAxisAlignment.stretch,
      children: [
        _StatusChip(
          label: selectedCount == 0
              ? '$totalTasks tugas tersimpan'
              : '$selectedCount tugas dipilih',
          color: selectedCount == 0
              ? const Color(0xFF2563EB)
              : const Color(0xFF0F766E),
        ),
        const SizedBox(height: 8),
        Row(
          children: [
            Expanded(
              child: TextButton(
                onPressed: totalTasks == 0
                    ? null
                    : () => context.read<TodoProvider>().clearTasks(),
                child: const Text('Hapus semua'),
              ),
            ),
            const SizedBox(width: 8),
            Expanded(
              child: OutlinedButton(
                onPressed: selectedCount == 0
                    ? null
                    : () => context.read<TodoProvider>().deleteSelectedTasks(),
                style: OutlinedButton.styleFrom(
                  minimumSize: const Size(0, 42),
                  foregroundColor: const Color(0xFFB42318),
                  side: const BorderSide(color: Color(0xFFF3B5AF)),
                  shape: RoundedRectangleBorder(
                    borderRadius: BorderRadius.circular(8),
                  ),
                ),
                child: const Text('Hapus pilihan'),
              ),
            ),
          ],
        ),
      ],
    );
  }
}

class _TaskList extends StatelessWidget {
  const _TaskList();

  @override
  Widget build(BuildContext context) {
    final todoProvider = context.watch<TodoProvider>();
    final tasks = todoProvider.tasks;

    if (tasks.isEmpty) {
      return _Surface(
        child: Container(
          alignment: Alignment.center,
          constraints: const BoxConstraints(minHeight: 150),
          child: Column(
            mainAxisSize: MainAxisSize.min,
            children: [
              Container(
                width: 58,
                height: 58,
                alignment: Alignment.center,
                decoration: BoxDecoration(
                  color: Colors.white.withValues(alpha: 0.46),
                  borderRadius: BorderRadius.circular(8),
                ),
                child: const Text(
                  '0',
                  style: TextStyle(
                    color: Color(0xFF2563EB),
                    fontSize: 24,
                    fontWeight: FontWeight.w800,
                  ),
                ),
              ),
              const SizedBox(height: 12),
              Text(
                'Belum ada tugas',
                style: Theme.of(
                  context,
                ).textTheme.titleMedium?.copyWith(fontWeight: FontWeight.w800),
              ),
              const SizedBox(height: 4),
              Text(
                'Tambahkan tugas pertama untuk memulai.',
                textAlign: TextAlign.center,
                style: Theme.of(context).textTheme.bodyMedium?.copyWith(
                  color: const Color(0xFF667085),
                ),
              ),
            ],
          ),
        ),
      );
    }

    return _Surface(
      child: ListView.separated(
        shrinkWrap: true,
        physics: const NeverScrollableScrollPhysics(),
        itemCount: tasks.length,
        separatorBuilder: (_, _) => const SizedBox(height: 10),
        itemBuilder: (context, index) {
          final isSelected = todoProvider.isSelected(index);

          return DecoratedBox(
            decoration: BoxDecoration(
              color: isSelected
                  ? const Color(0xFFDBEAFE).withValues(alpha: 0.72)
                  : Colors.white.withValues(alpha: 0.42),
              borderRadius: BorderRadius.circular(8),
              border: Border.all(
                color: isSelected
                    ? const Color(0xFF60A5FA)
                    : Colors.white.withValues(alpha: 0.68),
              ),
            ),
            child: ListTile(
              onTap: () =>
                  context.read<TodoProvider>().toggleTaskSelection(index),
              minVerticalPadding: 12,
              leading: Checkbox(
                value: isSelected,
                onChanged: (_) =>
                    context.read<TodoProvider>().toggleTaskSelection(index),
              ),
              title: Text(
                tasks[index],
                style: Theme.of(context).textTheme.titleSmall?.copyWith(
                  fontWeight: FontWeight.w700,
                  color: const Color(0xFF0F172A),
                ),
              ),
              subtitle: Text(
                'Tugas ${index + 1}',
                style: const TextStyle(color: Color(0xFF64748B)),
              ),
            ),
          );
        },
      ),
    );
  }
}

class _FcmStatus extends StatelessWidget {
  const _FcmStatus();

  @override
  Widget build(BuildContext context) {
    final notification = context.watch<NotificationProvider>();
    final token = notification.fcmToken;

    return _Surface(
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          const _SectionTitle(
            title: 'Firebase Cloud Messaging',
            subtitle: 'Status koneksi dan notifikasi terakhir.',
          ),
          const SizedBox(height: 14),
          _StatusChip(
            label: notification.isFirebaseReady
                ? 'Firebase siap'
                : 'Menyiapkan Firebase',
            color: notification.isFirebaseReady
                ? const Color(0xFF12B76A)
                : const Color(0xFFF59E0B),
          ),
          const SizedBox(height: 12),
          Text(
            notification.isFirebaseReady
                ? 'Aplikasi siap menerima pesan FCM dari Firebase Console atau Postman.'
                : notification.errorMessage ??
                      'Menunggu inisialisasi Firebase.',
            style: Theme.of(
              context,
            ).textTheme.bodyMedium?.copyWith(color: const Color(0xFF475467)),
          ),
          if (token != null) ...[
            const SizedBox(height: 12),
            Container(
              width: double.infinity,
              padding: const EdgeInsets.all(12),
              decoration: BoxDecoration(
                color: Colors.white.withValues(alpha: 0.44),
                borderRadius: BorderRadius.circular(8),
                border: Border.all(color: Colors.white.withValues(alpha: 0.68)),
              ),
              child: SelectableText(
                'Token FCM:\n$token',
                style: Theme.of(context).textTheme.bodySmall?.copyWith(
                  color: const Color(0xFF344054),
                  fontWeight: FontWeight.w600,
                ),
              ),
            ),
          ],
          if (notification.lastTitle != null || notification.lastBody != null)
            Padding(
              padding: const EdgeInsets.only(top: 12),
              child: DecoratedBox(
                decoration: BoxDecoration(
                  color: const Color(0xFFFFFAEB).withValues(alpha: 0.72),
                  borderRadius: BorderRadius.circular(8),
                  border: Border.all(color: const Color(0xFFFEDFAA)),
                ),
                child: Padding(
                  padding: const EdgeInsets.all(12),
                  child: Row(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Expanded(
                        child: Column(
                          crossAxisAlignment: CrossAxisAlignment.start,
                          children: [
                            Text(
                              notification.lastTitle ?? 'Notifikasi masuk',
                              style: Theme.of(context).textTheme.titleSmall
                                  ?.copyWith(
                                    fontWeight: FontWeight.w800,
                                    color: const Color(0xFF7A2E0E),
                                  ),
                            ),
                            const SizedBox(height: 4),
                            Text(
                              notification.lastBody ?? '-',
                              style: Theme.of(context).textTheme.bodyMedium
                                  ?.copyWith(color: const Color(0xFF93370D)),
                            ),
                          ],
                        ),
                      ),
                    ],
                  ),
                ),
              ),
            ),
        ],
      ),
    );
  }
}
