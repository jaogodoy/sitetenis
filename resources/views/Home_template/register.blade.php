<form method="POST" action="{{ route('client.register') }}">
    @csrf
    <input type="text" name="name" placeholder="Nome" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Senha" required>
    <input type="password" name="password_confirmation" placeholder="Confirme a Senha" required>
    <button type="submit">Registrar Cliente</button>
</form>
