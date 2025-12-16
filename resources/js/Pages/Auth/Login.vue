<script lang="ts" setup>
    import Button from '@/Components/ui/button/Button.vue';
    import { Card, CardContent, CardDescription, CardTitle } from '@/Components/ui/card';
    import CardHeader from '@/Components/ui/card/CardHeader.vue';
    import Input from '@/Components/ui/input/Input.vue';
    import Label from '@/Components/ui/label/Label.vue';
    import LoginLayout from '@/Layouts/LoginLayout.vue';
    import { Form, Head } from '@inertiajs/vue3';
</script>
<template>
    <Head title="Login" />
    <LoginLayout>
        <Card class="max-w-sm min-w-xs">
            <CardHeader>
                <CardTitle>Welcome to Vehease!</CardTitle>
                <CardDescription>Please sign in to your account</CardDescription>
            </CardHeader>
            <CardContent>
                <Form action="/auth/login" method="post">
                    <div>
                        <Label for="email" class="mb-2 block">Email</Label>
                        <Input id="email" placeholder="Email" class="mb-4" name="email" />
                    </div>
                    <div>
                        <Label for="email" class="mb-2 block">Password</Label>
                        <Input id="password" placeholder="Password" type="password" name="password" />
                    </div>
                    <Button type="submit" class="mt-6 w-full">Sign In</Button>
                </Form>
            </CardContent>
        </Card>
    </LoginLayout>
</template>
