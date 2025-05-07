import BlueSwirl from '/public/images/blue-swirl.png';
import Input from './components/Input';
import { MdOutlineBrandingWatermark } from 'react-icons/md';
import { TbBoxModel2, TbHash } from 'react-icons/tb';
import { motion } from 'framer-motion';

const App = () => {
    return (
        <div className="min-h-screen w-full bg-dark-900 p-8">
            <motion.h1
                initial={{ opacity: 0, y: 20 }}
                animate={{ opacity: 1, y: 0 }}
                transition={{
                    duration: 0.6,
                    delay: 0.6,
                    ease: 'easeOut'
                }}
                className="font-inter font-bold text-5xl primary-text-gradient"
            >
                Hello,<br />John Doe
            </motion.h1>
            <motion.p
                initial={{ opacity: 0, y: 20 }}
                animate={{ opacity: 1, y: 0 }}
                transition={{
                    duration: 0.6,
                    delay: 1.2,
                    ease: 'easeOut',
                }}
                className="text-white font-inter text-lg primary-text-gradient mt-4"
            >
                Need help with your appliance?
            </motion.p>
            <motion.img
              src={BlueSwirl}
              alt="blue swirl"
              className="w-full mt-4"
              initial={{ opacity: 0, scale: 1 }}
              animate={{
                opacity: 1,
              }}
              transition={{
                opacity: { duration: 0.6, ease: 'easeOut' },
              }}
            />
            <motion.p
                initial={{ opacity: 0, y: 20 }}
                animate={{ opacity: 1, y: 0 }}
                transition={{
                    duration: 0.6,
                    delay: 1.8,
                    ease: 'easeOut',
                }}
                className="text-white font-inter text-lg primary-text-gradient mt-4"
            >
                I'll need some information
            </motion.p>
            <motion.div
                className="flex flex-col w-full gap-4 mt-4"
                initial={{ opacity: 0, y: 20 }}
                animate={{ opacity: 1, y: 0 }}
                transition={{
                    duration: 0.6,
                    delay: 2.4,
                    ease: 'easeOut',
                }}
            >
                <Input
                    placeholder="Brand"
                    EndAdornment={MdOutlineBrandingWatermark}
                />
                <Input
                    placeholder="Model"
                    EndAdornment={TbBoxModel2}
                />
                <Input
                    placeholder="Serial"
                    EndAdornment={TbHash}
                />
            </motion.div>
            <motion.button
                className="w-full py-2 rounded-lg mt-10 font-inter text-white primary-gradient text-xl"
                initial={{ opacity: 0, y: 20 }}
                animate={{ opacity: 1, y: 0 }}
                transition={{
                    duration: 0.6,
                    delay: 2.4,
                    ease: 'easeOut',
                }}
            >
                Continue
            </motion.button>
        </div>
    );
}

export default App;
