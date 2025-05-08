import { createBrowserRouter } from 'react-router-dom';
import Home from './pages/Home';
import Options from './pages/Options';
import Faults from './pages/Faults';
import Tests from './pages/Tests';

const router = createBrowserRouter([
    {
        path: '/dashboard',
        element: <Home />,
    },
    {
        path: '/dashboard/options',
        element: <Options />,
    },
    {
        path: '/dashboard/faults',
        element: <Faults />,
    },
    {
        path: '/dashboard/tests',
        element: <Tests />,
    },
]);

export default router;
