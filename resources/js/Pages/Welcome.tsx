import { Link, Head } from '@inertiajs/react'
import { PageProps } from '@/types'

export default function Welcome({
    auth,
    laravelVersion,
    phpVersion,
}: PageProps<{ laravelVersion: string; phpVersion: string }>) {
    const handleImageError = () => {
        document
            .getElementById('screenshot-container')
            ?.classList.add('!hidden')
        document.getElementById('docs-card')?.classList.add('!row-span-1')
        document.getElementById('docs-card-content')?.classList.add('!flex-row')
        document.getElementById('background')?.classList.add('!hidden')
    }

    return (
        <>
            <Head title="Welcome" />
            <div className="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
                {/* <Card>
                    <CardHeader>
                        <CardTitle>Card Title</CardTitle>
                        <CardDescription>Card Description</CardDescription>
                    </CardHeader>
                    <CardContent>
                        <p>Card Content</p>
                    </CardContent>
                    <CardFooter>
                        <p>Card Footer</p>
                    </CardFooter>
                </Card> */}
            </div>
        </>
    )
}
